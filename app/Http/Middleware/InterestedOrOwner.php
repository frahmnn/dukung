<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Chatroom;
use App\Models\Offer;
use Auth;

class InterestedOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ownerid = Offer::select("applicant")->where("id", $request->route("offer"))->first()->applicant;
        if(Chatroom::where("offer", $request->route("offer"))->where("interestee", Auth::user()->id)->exists()){
            $request->attributes->set("type", "i");
            $request->attributes->set("ownerid",  $ownerid);}
        elseif($ownerid == Auth::user()->id){
            $request->attributes->set("type", "o");}
        else{
            return redirect()->route("index");}
        return $next($request);
    }
    
}
