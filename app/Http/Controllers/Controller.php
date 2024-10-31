<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;
use App\Models\Chatroom;
use App\Models\Verification;
use App\Models\Tag;
use Auth;
class Controller
{
    public function index(){
        $offers = Offer::select("id", "name", "applicant", "closed_date", "created_at")->where("closed_date", ">=", date("Y-m-d"))->orderBy("created_at", "desc")->get();
        $tags = Tag::select("tag", "offer")->wherein("offer", $offers->select("id"))->get()->groupBy("offer")->toArray();
        $interesteds = (Auth::guest())? [] : Chatroom::select("offer")->where("interestee", Auth::user()->id)->get()->keyby("offer");
        return view("index")->with(
            "offers", $offers)->with(
            "tags", $tags)->with(
            "interesteds", $interesteds);}

    public function offer($offer){
        $offer = Offer::find($offer);
        if (date('Y-m-d', strtotime($offer->closed_date)) < date('Y-m-d')) {
            return redirect()->route("index");}
        $interested = Auth::guest() ? false : Chatroom::where("offer", $offer->id)->where("interestee", Auth::user()->id)->exists();
        $applicant = User::select("name", "organization")->find($offer->applicant);
        $verified = Verification::where("applicant", $offer->applicant)->where("status", "a")->exists();
        $tags = Tag::select("tag")->where("offer", $offer->id)->get();
        $images = [];
        $imagedir = public_path("images/posts/" . $offer->id);
        $profilepicture = glob(public_path("images/profiles") . "/" . $offer->applicant . ".*");
        if(is_dir($imagedir)){
            foreach(glob($imagedir . "/*.*") as $image){
                $images[]=basename($image);
            }}
        return view("offers.offer")->with(
            "offer", $offer)->with(
            "applicant", $applicant)->with(
            "interested", $interested)->with(
            "verified", $verified)->with(
            "tags", $tags)->with(
            "images", $images)->with(
            "to_profilepicture", empty($profilepicture) ? "default.png" : htmlspecialchars(basename($profilepicture[0])));
        }

    public function search(Request $request){
        $offers = Offer::select("id", "name", "applicant", "closed_date", "created_at")->where("closed_date", ">=", date("Y-m-d"))->where("name", "like", "%" . $request->query("query") . "%");
        foreach ($request->query as $key => $value){
            if(strpos($key, "tag_") === 0){
                $filter[$value]=$value;
            }}
        if(isset($filter)){
            $tags = Tag::select("tag", "offer")->whereIn("tag", $filter)->get()->groupBy("offer")->toArray();
            $offers->whereIn("id", array_keys($tags));}
        else{
            $tags = Tag::select("tag", "offer")->whereIn("offer", $offers->pluck("id"))->get()->groupBy("offer")->toArray();}
        switch($request->query("sort")){
            case "created_at_asc":
                $offers->orderBy("created_at", "asc");break;
            case "closed_date_desc":
                $offers->orderBy("closed_date", "desc");break;
            case "closed_date_asc":
                $offers->orderBy("closed_date", "asc");break;
            default:
                $offers->orderBy("created_at", "desc");
                $sort = "created_at_desc";
            break;}
        $offers = $offers->get();
        $interesteds = (Auth::guest())? [] : Chatroom::select("offer")->where("interestee", Auth::user()->id)->get()->keyby("offer");
        return view("search")->with(
            "offers", $offers)->with(
            "tags", $tags)->with(
            "query", $request->query("query") ?? "")->with(
            "filter", $filter ?? [])->with(
            "sort", $sort ?? $request->query("sort"));
        }

    public function support($page){
        if(!view()->exists("support." . $page)){
            return redirect()->route("support", "welcome");}
        return view("support." . $page)->with("page", $page);}

    public function zzcheatemail(){
        User::whereNull('email_verified_at')->update(['email_verified_at' => now()]);
        return response()->json(["message" => "Semua email sudah diverifikasi"]);
    }
        
}