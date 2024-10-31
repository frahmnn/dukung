<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;
use App\Models\User;
use App\Models\Offer;
use File;
use Storage;
class AdminController extends Controller
{
    public function index(){return view("admins.index");}

    public function verifications(){
        $verifications = Verification::where("status", "w")->get()->keyBy("id");
        $users = User::select("id", "name", "email", "organization")->wherein("id", $verifications->select("applicant"))->get()->keyBy("id");
        $filenames = [];
        //tamperfile
        foreach($verifications->select("applicant") as $verification_id => $applicant){
            $folder = public_path("verifications/" . $applicant["applicant"]);
            if(is_dir($folder)){
                foreach(File::files($folder) as $file){
                    $filenames[$verification_id][]=$file->getFilename();
                }
            }}
        return view("admins.verifications")->with(
            "verifications", $verifications)->with(
            "users", $users)->with(
            "filenames", $filenames);
        }

    public function verifyverification(Request $request){
        Verification::where("id", $request->query("verification"))->update(["status" => $request->query("action")]);
        if($request->query("action") == "a"){
            $action = "terima";}
        else{
            $action = "tolak";}
        return redirect()->route("admin.verifications")->with("success", "Berhasil " . $action . " Verifikasi!");}

    public function users(){
        $users = User::whereNotNull("email_verified_at")->select("id", "name", "email", "role", "organization")->get()->keyBy("id");
        $verifications = Verification::where("status", "a")->select("id", "applicant")->pluck("applicant", "id")->toarray();
        $filenames = [];
        //tamperfile
        foreach($verifications as $id => $applicant){
            $folder = public_path("verifications/" . $applicant);
            if(is_dir($folder)){
                foreach(File::files($folder) as $file){
                    $filenames[$id][]=$file->getFilename();
                }
            }}
        return view("admins.users")->with(
            "users", $users)->with(
            "verifications", $verifications)->with(
            "filenames", $filenames);
        }

    public function usersedit(Request $request){
        //tamperfile
        foreach($_POST as $key => $_POS){
            if(preg_match("/^[a-f0-9\-]{36}_/", $key)){
                $key = explode("_", $key);
                if($_POS == "true"){
                    foreach(Offer::select("id")->where("applicant", $key[0])->get() as $offer){
                        $proposal=public_path("proposals/" . $offer->id);
                        $offer=public_path("images/posts/" . $offer->id);
                        if(is_dir($offer)){
                            File::deleteDirectory($offer);}
                        if(is_dir($proposal)){
                            File::deleteDirectory($proposal);
                        }}
                    $verification=public_path("verifications/" . $key[0]);
                    if(is_dir($verification)){
                        File::deleteDirectory($verification);}
                    $profilepicture = glob(public_path("images/profiles") . "/" . $key[0] . ".*");
                    if(!empty($profilepicture)){
                        File::delete($profilepicture[0]);}
                    User::where("Id", $key[0])->delete();}
                else{
                    User::where("id", $key[0])->update([$key[1] => $_POS]);
                }
            }}
        return redirect()->route("admin.users")->with("success", "Berhasil perbarui Data!");}

    public function deleteverification(Request $request){
        $userid = key($request->query->all());
        $folder=public_path("verifications/" . $userid);
        if(is_dir($folder)){
            File::deleteDirectory($folder);}
        Verification::where("Applicant", $userid)->delete();
        return redirect()->route("admin.users")->with("success", "Berhasil perbarui Data!");}

    public function accessfile(Request $request){
        $file=public_path("verifications/" . $request->query("userid") . "/" . $request->query("filename"));
        if(!File::exists($file)){
            return back()->with("error", "file tidak ditemukan");}
        return response()->download($file);
    }
}
