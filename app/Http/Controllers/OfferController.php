<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offer;
use App\Models\Chatroom;
use App\Models\Chat;
use App\Models\Verification;
use App\Models\Thank;
use App\Models\Tag;
use App\Models\Notification;
use App\Events\Websocket;
use Illuminate\Support\Str;
use Auth;
use File;

class OfferController extends Controller
{
    public function create(){return view("offers.create");}

    public function insert(Request $request){
        $request->validate([
            "image.*"=>     "file|mimes:jpeg,png,jpg|max:2048",
            "proposal"=>    "file|mimes:doc,docx,pdf|max:51200"]);
        $offerid=Str::uuid();
        $images = collect($request->file("image"));
        //tamperfile
        if($request->hasFile("proposal")){
            $request->file("proposal")->storeAs("proposals/" . $offerid . "/", $request->file("proposal")->getClientOriginalName());}
        foreach(json_decode($request->order) as $key => $order){
            $image = $images->first(function($file) use ($order){
                return $file->getClientOriginalName() == $order;});
            $image->storeAs("images/posts/" . $offerid . "/", $key . '.' . $image->getClientOriginalExtension());}
        Offer::create([
            "id"=>          $offerid,
            "name"=>        $request->name,
            "applicant"=>   Auth::user()->id,
            "description"=> $request->description,
            "closed_date"=> $request->closed_date]);
        foreach($request->all() as $key => $value){
            if(strpos($key, "tag_") === 0){
                Tag::create([
                    "id"=>      Str::uuid(),
                    "tag"=>     $value,
                    "offer"=>   $offerid
                ]);
            }}
        return redirect()->route("offer.offer", $offerid);}

    public function dashboard($offer){
        $chatrooms = Chatroom::select("id", "interestee", "created_at")->where("offer", $offer)->get();
        $notifications = Notification::select("chatroom")->where("user", Auth::user()->id)->wherein("chatroom", $chatrooms->select("id"))->get()->keyby("chatroom");
        $interestee_ids=  $chatrooms->select("interestee");
        $interestees = User::select("id", "name", "organization")->wherein("id", $interestee_ids)->get()->keyby("id");
        $verifications = Verification::select("applicant")->wherein("applicant", $interestee_ids)->where("status", "a")->get()->keyBy("applicant");
        $tags = Tag::select("tag")->where("offer", $offer)->get()->keyby("tag");
        $images = [];
        $imagedir = public_path("images/posts/" . $offer);
        if(is_dir($imagedir)){
            foreach(glob($imagedir . "/*.*") as $image){
                $images[]=basename($image);
            }}
        $proposaldir = public_path("proposals/" . $offer);
        $proposal=false;
        if(is_dir($proposaldir)){
            $proposal = glob($proposaldir . "/*.*");
            $proposal = empty(glob($proposaldir . "/*.*"))? false : basename($proposal[0]);}
        $offer = Offer::find($offer);
        return view("offers.dashboard")->with(
            "offer", $offer)->with(
            "images", $images)->with(
            "proposal", $proposal)->with(
            "interestees", $interestees)->with(
            "chatrooms", $chatrooms)->with(
            "verifications", $verifications)->with(
            "tags", $tags)->with(
            "notifications", $notifications);
        }

    public function edit(Request $request, $offer){
        $request->validate([
            "image.*"=>     "file|mimes:jpeg,png,jpg|max:2048"]);
        $tags = Tag::select("id", "tag")->where("offer", $offer)->get()->keyby("tag");
        //tamperfile
        $source = public_path("images/posts/" . $offer);
        $orders = json_decode($request->order);
        foreach($orders as $key => $order){
            if($order->status == "new" || explode('.', $order->name)[0] != $key){
                if(is_dir($source . "_old")){
                    File::deleteDirectory($source . "_old");}
                if(is_dir($source)){
                    rename($source, $source . "_old");
                    mkdir($source, 0755, true);}
                $images = collect($request->file("image"));
                foreach($orders as $key => $order){
                    if($order->status == "old"){
                        $extension = explode(".", $order->name);
                        rename($source . "_old/". $order->name, $source . "/" . $key . "." . end($extension));}
                    else{
                        $image = $images->first(function($file) use ($order){
                            return $file->getClientOriginalName() == $order->name;});
                        $image->storeAs("images/posts/" . $offer . "/", $key . "." . $image->getClientOriginalExtension());
                    }}
                if(is_dir($source . "_old")){
                    File::deleteDirectory($source . "_old");}
                break;
            }}
        if(empty($orders)){
            if(is_dir($source)){
                File::deleteDirectory($source);
            }}
        Offer::where("id", $offer)->update([
            "name" => $request->name,
            "description" => $request->description,
            "closed_date" => $request->closed_date]);
        foreach ($request->all() as $key => $value){
            if(strpos($key, "tag_") === 0){
                if (isset($tags[$value])){
                    $tags->forget($value);}
                else{
                    Tag::create([
                        "id"=>      Str::uuid(),
                        "tag"=>     $value,
                        "offer"=>   $offer
                    ]);
                }
            }}
        foreach($tags as $tag){
            Tag::where("id", $tag->id)->delete();}
            return redirect()->route("offer.dashboard", $offer)->with("success", "Berhasil perbarui event!");
        }

    public function previewproposal($offer){
        //tamperfile
        $proposaldir = public_path("proposals/" . $offer);
        if(!is_dir($proposaldir)){
            return back()->with("error", "file tidak ditemukan");}
        $proposal = glob($proposaldir . "/*.*");
        if(empty($proposal)){
            return back()->with("error", "file tidak ditemukan");}
        return response()->download($proposaldir . "/" . basename($proposal[0]));}

    public function editproposal(Request $request, $offer){
        $request->validate([
            "proposal" => "file|mimes:doc,docx,pdf|max:51200"]);
        //tamperfile
        $proposaldir = public_path("proposals/" . $offer);
        if(is_dir($proposaldir)){
            File::deleteDirectory($proposaldir);}
        if($request->hasFile("proposal")){
            $request->file("proposal")->storeAs("proposals/" . $offer . "/", $request->file("proposal")->getClientOriginalName());}
        return redirect()->route("offer.dashboard", $offer)->with("success", "Berhasil perbarui event!");}

    public function interested($offer){
        $chatroomid = Str::uuid();
        Chatroom::create([
            "id"=>          $chatroomid,
            "offer"=>       $offer,
            "interestee"=>  Auth::user()->id]);
        $to = Offer::select("name", "applicant")->where("id", $offer)->first();
        $content["offername"] = $to->name;
        $to = $to->applicant;
        if(!Notification::where('user', $to)->where('chatroom', $chatroomid)->exists()){
                Notification::create([
                    "id" => Str::uuid(),
                    "user" => $to,
                    "chatroom" => $chatroomid,
                ]);}
        $about = "interested";
        $content["offer"] = $offer;
        $content["interesteeid"] = Auth::user()->id;
        $content["interesteename"] = Auth::user()->name;
        event(new Websocket($to, $about, $content));
        return redirect()->route("offer.chat", $offer)->with("success", "Kami sudah mengirim notifikasi untuk penyelengara event. Selamat berdiskusi!");}

    public function chat(Request $request, $offer){
        switch($request->get("type")){
            case "i":
                $chatroom = Chatroom::select("id", "grantproposal")->where("interestee", Auth::user()->id)->where("offer", "$offer")->first();
                $to = User::select("name", "organization")->where("id", $request->get("ownerid"))->first();
                $verified = Verification::where("applicant", $request->get("ownerid"))->where("status", "a")->exists();
                $profilepicture = glob(public_path("images/profiles") . "/" . $request->get("ownerid") . ".*");
                $to_offers = Offer::where("applicant", $request->get("ownerid"))->get();
                $to_thanks = Thank::where("user", $request->get("ownerid"))->count();
            break;
            case "o":
                if(!$request->query("chatroom")){
                    return redirect()->route("offer.dashboard", $offer);}
                $chatroom = Chatroom::select("id", "interestee", "grantproposal")->where("id", $request->query("chatroom"))->first();
                $to = User::select("id", "name", "organization")->where("id", $chatroom->interestee)->first();
                $verified = Verification::where("applicant", $chatroom->interestee)->where("status", "a")->exists();
                $profilepicture = glob(public_path("images/profiles") . "/" . $to->id . ".*");
                $to_offers = Offer::where("applicant", $to->id)->get();
                $to_thanks = Thank::where("user", $to->id);
                $thanked = $to_thanks->where("offer", $offer)->exists();
                $to_thanks = $to_thanks->count();
            break;}

            $withproposal = true;
            $proposaldir = public_path("proposals/" . $offer);
            if(!is_dir($proposaldir)){
                $withproposal = false;}
            $proposal = glob($proposaldir . "/*.*");
            if(empty($proposal)){
                $withproposal = false;}
            foreach (Notification::where("user", Auth::user()->id)->where("chatroom", $chatroom->id)->get() as $notification) {
                $notification->delete();
                }

            $offer_name = Offer::select("name")->where("id", $offer)->first()->name;
            $to_activeoffers = $to_offers->where("closed_date", ">=", date("Y-m-d"))->count();
            $to_offers = $to_offers->count();
        $messages = Chat::select("from", "message", "created_at")->where("chatroom", $chatroom->id)->orderBy("created_at", "asc")->get();
        return view("offers.chat")->with(
            "to", $to)->with(
            "offer", $offer)->with(
            "chatroom", $request->get("type") == "i"? null : $chatroom->id)->with(
            "messages", $messages)->with(
            "grantproposal", $chatroom->grantproposal)->with(
            "verified", $verified)->with(
            "thanked", $request->get("type") == "i"? null : $thanked)->with(
            "to_profilepicture", empty($profilepicture) ? "default.png" : htmlspecialchars(basename($profilepicture[0])))->with(
            "to_thanks", $to_thanks)->with(
            "to_offers", $to_offers)->with(
            "to_activeoffers", $to_activeoffers)->with(
            "offer_name", $offer_name)->with(
            "withproposal", $withproposal);}

    public function sendchat(Request $request, $offer){
        $content["timestamp"] = now();
        $applicant = Offer::select("applicant")->where("id", $offer)->first()->applicant;
        if($applicant == Auth::user()->id){
            $chatroom = $request->query("chatroom");
            $to = Chatroom::select("interestee")->where("id", $chatroom)->first()->interestee;}
        else{
            $chatroom = Chatroom::select("id")->where("interestee", Auth::user()->id)->where("offer", "$offer")->first()->id;
            $to = $applicant;}
        Chat::create([
            "id"=>          Str::uuid(),
            "from"=>        Auth::user()->id,
            "chatroom"=>    $chatroom,
            "message"=>     $request->message]);
        if(!Notification::where('user', $to)->where('chatroom', $chatroom)->exists()){
            Notification::create([
                "id"=>         Str::uuid(),
                "user"=>       $to,
                "chatroom"=>   $chatroom
            ]);}
        $about = "incomingmessage";
        $content["message"] = $request->message;
        $content["offer"] = $offer;
        $content["fromid"] = Auth::user()->id;
        $content["fromname"] = Auth::user()->name;
        event(new Websocket($to, $about, $content));
        return response()->json(['message' => $request->message, "timestamp" => $content["timestamp"]]);}

    public function grantproposal(Request $request, $offer){
        $chatroom = Chatroom::where("id", $request->query("chatroom"));
        $chatroom->update(["grantproposal" => 1]);
        $to = $chatroom->select("interestee")->first()->interestee;
        $about = "grantproposal";
        $content["fromname"] = Auth::user()->name;
        $content["offername"] = Offer::select("name")->where("id", $chatroom->select("offer")->first()->offer)->first()->name;
        if(!Notification::where('user', $to)->where('chatroom', $request->query("chatroom"))->exists()){
            Notification::create([
                "id"=>         Str::uuid(),
                "user"=>       $to,
                "chatroom"=>   $request->query("chatroom")
            ]);}
        event(new Websocket($to, $about, $content));
        return redirect()->route("offer.chat", ['offer' => $offer, 'chatroom' => $request->query("chatroom")])->with("success", "Berhasil buka akses!");}

    public function proposal($offer){
        if(Chatroom::select("grantproposal")->where("interestee", Auth::user()->id)->where("offer", "$offer")->first()->grantproposal == 0){
            return back();}
        //tamperfile
        $proposaldir = public_path("proposals/" . $offer);
        if(!is_dir($proposaldir)){
            return back()->with("error", "file tidak ditemukan");}
        $proposal = glob($proposaldir . "/*.*");
        if(empty($proposal)){
            return back()->with("error", "file tidak ditemukan");}
        return response()->download($proposaldir . "/" . basename($proposal[0]));}

    public function thank(Request $request, $offer){
        $to = Chatroom::select("interestee")->where("id", $request->query("chatroom"))->first()->interestee;
        Thank::create([
            "id"=>      Str::uuid(),
            "user"=>    $to,
            "offer"=>   $offer]);
        $about = "thanked";
        $content = Auth::user()->name;
        event(new Websocket($to, $about, $content));
        return redirect()->route("offer.chat", ['offer' => $offer, 'chatroom' => $request->query("chatroom")])->with("success", "Berhasil beri terima kasih!");}

    public function delete($offer){
        $imagedir = public_path("images/posts/" . $offer);
        $proposaldir = public_path("proposals/" . $offer);
        if(is_dir($imagedir)){
            File::deleteDirectory($imagedir);}
        if(is_dir($proposaldir)){
            File::deleteDirectory($proposaldir);}
        foreach(Tag::select("id")->where("offer", $offer)->get() as $tag){
            Tag::where("id", $tag->id)->delete();}
        Offer::where("id", $offer)->delete();
        return redirect()->route("user.offers")->with("success", "Berhasil hapus event!");
    }
}

