<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Offer;
use Auth;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Offer::select("applicant")->where("id", $request->route("offer"))->first()->applicant != Auth::user()->id) {
            return redirect()->route("index");
        }
        return $next($request);
    }
}
