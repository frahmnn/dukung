<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Verification;
use App\Models\Offer;
use App\Models\Chatroom;
use App\Models\Thank;
use App\Models\Notification;
use Auth;
use File;

class UserController extends Controller
{
    public function completeprofile(){
        if(Auth::user()->completeprofile == 1){
            return redirect()->route("index");}
        return view("users.completeprofile");}

    public function postcompleteprofile(Request $request){
        $request->validate([
            "image" => "image|mimes:jpeg,png,jpg|max:2048"]);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $img = imagecreatefromstring(file_get_contents($file->getRealPath()));
            $width = imagesx($img);
            $height = imagesy($img);
            $size = min($width, $height);
            $croppedImg = imagecreatetruecolor($size, $size);
            imagecopyresampled($croppedImg, $img,
                0, 0,
                ($width - $size) / 2, ($height - $size) / 2,
                $size, $size,
                $size, $size);
            imagepng($croppedImg, public_path("images/profiles/" . Auth::user()->id . "." . $file->getClientOriginalExtension())); // Save as PNG
            imagedestroy($img);
            imagedestroy($croppedImg);}
        if(isset($request->organization)){
            User::where("id", Auth::user()->id)->update(["organization" => $request->organization]);
            $successmessage="Anda berhasil masuk sebagai Organisasi! Anda dapat melakukan verifikasi organisasi di menu user (Opsional)";}
        else{
            $successmessage="Anda berhasil masuk sebagai Individu!";}
        User::where("id", Auth::user()->id)->update(["completeprofile" => 1]);
        return redirect()->route("index")->with("success", $successmessage);}

    public function index(){
        $offers = Offer::where("applicant", Auth::user()->id)->get();
        $activeoffers = $offers->where("closed_date", ">=", date("Y-m-d"))->count();
        $offers = $offers->count();
        $thanks = Thank::where("user", Auth::user()->id)->count();
        return view("users.index")->with(
            "verification",Verification::select("status")->where("applicant", Auth::user()->id)->first()->status ?? null)->with(
            "offers", $offers)->with(
            "activeoffers", $activeoffers)->with(
            "thanks", $thanks);}

    public function newemail(Request $request){
        \Mail::to($request->email)->send(new \App\Mail\NewEmail(URL::temporarySignedRoute("user.changeemail", now()->addHour(), ["user" => Auth::user()->id])));
        User::where("id", Auth::user()->id)->update(["new_email" => $request->email]);
        return redirect()->route("user.index")->with("success", "Permintaan ganti email telah dikirim. Silakan cek email baru anda.");}

    public function changeemail(Request $request){
        if(Auth::user()->id != $request->query("user")){
            return redirect()->route("index");}
        if(User::where("email", Auth::user()->new_email)->exists()){
            return redirect()->route("user.index")->with("error", "Email sudah dipakai.");}
        User::where("id", Auth::user()->id)->update([
            "email"=>       Auth::user()->new_email,
            "new_email"=>   null]);
        return redirect()->route("user.index")->with("success", "Berhasil ganti email!");}

    public function changename(Request $request){
        User::where("id", Auth::user()->id)->update(["name" => $request->name]);
        return redirect()->route("user.index")->with("success", "Berhasil ganti Nama!");}

    public function changetype(Request $request){
        if($request->organization == null){
            Verification::where("Applicant", Auth::user()->id)->delete();}
        User::where("id", Auth::user()->id)->update(["organization" => $request->organization ?? null]);
        return redirect()->route("user.index")->with("success", "Berhasil ganti Tipe Pendaftar!");}

    public function applyverification(Request $request){
        $request->validate(["document.*" => "required|file|mimes:jpeg,png,jpg,doc,docx,odt,rtf,pdf|max:2048"]);
        //tamperfile
        if(Verification::where("Applicant", Auth::user()->id)->exists()){
            Verification::where("Applicant", Auth::user()->id)->delete();
            $folder=public_path("verifications/" . Auth::user()->id);
            if(is_dir($folder)){
                File::deleteDirectory($folder);
            }}
        foreach($request->file("document") as $file){
            $file->storeAs("verifications/" . Auth::user()->id . "/", $file->getClientOriginalName());}
        Verification::create([
            "id"        =>  Str::uuid(),
            "applicant" =>  Auth::user()->id]);
        return redirect()->route("user.index")->with("success", "Berhasil ajukan Verifikasi! Event anda menunggu pemeriksaan oleh admin.");}

    public function cancelverification(Request $request){
        //tamperfile
        $folder=public_path("verifications/" . Auth::user()->id);
        if(is_dir($folder)){
            File::deleteDirectory($folder);}
        Verification::where("Applicant", Auth::user()->id)->delete();
        return redirect()->route("user.index")->with("success", "Berhasil batalkan Verifikasi!");}

    public function offers(){
        $myoffers = Offer::select("id", "name", "closed_date")->where("applicant", Auth::user()->id)->orderBy("created_at", "desc")->get();
        $interestees = Chatroom::select("offer")
            ->whereIn("offer", $myoffers->select("id"))
            ->get()
            ->groupBy("offer")
            ->map(function ($group){
                return $group->count();})
            ->toArray();
        $notifications = Notification::where("user", Auth::user()->id)->get()->keyby("chatroom");
        $notifications = Chatroom::select("offer")->wherein("id", $notifications->select("chatroom"))->get()->keyby("offer");
        $interesteds = Chatroom::select("offer")->where("interestee", Auth::user()->id)->orderBy("created_at", "desc")->get();
        $interested_offers = Offer::select("id", "name", "closed_date")->wherein("id", $interesteds)->get()->keyby("id");
        return view("users.offers")->with(
            "myoffers", $myoffers)->with(
            "interestees", $interestees)->with(
            "interesteds", $interesteds)->with(
            "interested_offers", $interested_offers)->with(
            "notifications", $notifications);
        }

    public function changeprofilepicture(Request $request){
        $profilepicture = glob(public_path("images/profiles") . "/" . Auth::user()->id . ".*");
        if(!empty($profilepicture)){
            File::delete($profilepicture[0]);}
        $file = $request->file('image');
        $img = imagecreatefromstring(file_get_contents($file->getRealPath()));
        $width = imagesx($img);
        $height = imagesy($img);
        $size = min($width, $height);
        $croppedImg = imagecreatetruecolor($size, $size);
        imagecopyresampled($croppedImg, $img,
            0, 0,
            ($width - $size) / 2, ($height - $size) / 2,
            $size, $size,
            $size, $size);
        imagepng($croppedImg, public_path("images/profiles/" . Auth::user()->id . "." . $file->getClientOriginalExtension())); // Save as PNG
        imagedestroy($img);
        imagedestroy($croppedImg);
        return redirect()->route("user.index")->with("success", "Berhasil ganti foto profil!");}

    public function deleteprofilepicture(){
        $profilepicture = glob(public_path("images/profiles") . "/" . Auth::user()->id . ".*");
        if(!empty($profilepicture)){
            File::delete($profilepicture[0]);}
        return redirect()->route("user.index")->with("success", "Berhasil hapus foto profil!");}
}
