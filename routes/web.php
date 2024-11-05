<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfferController;
use App\Http\Middleware\CompleteProfile;
use App\Http\Middleware\NotBanned;
use App\Http\Middleware\Admin;
use App\Http\Middleware\InterestedOrOwner;
use App\Http\Middleware\Owner;

Auth::routes(['verify'=>true]);

Route::get(     '/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name(    'dashboard');  

Route::get(     "/",                                    [Controller::class,         "index"])->name(                "index");
Route::get(     "/offer/{offer}",                       [OfferController::class,    "offer"])->name(                "offer.offer");
Route::get(     "/search",                              [Controller::class,         "search"])->name(               "search");
Route::get(     "/support/{page}",                      [Controller::class,         "support"])->name(              "support");
Route::get(     "/zzcheatemail",                        [Controller::class,         "zzcheatemail"])->name(         "zzcheatemail");

Route::middleware(['auth', 'verified', NotBanned::class])->group(function(){
Route::get(     "/user/completeprofile",                [UserController::class,     "completeprofile"])->name(      "user.completeprofile");
Route::post(    "/user/completeprofile",                [UserController::class,     "postcompleteprofile"])->name(  "user.postcompleteprofile");
});

Route::middleware(["auth", "verified", NotBanned::class, CompleteProfile::class])->group(function(){
Route::get(     "/user",                                [UserController::class,     "index"])->name(                "user.index");
Route::post(    "/user",                                [UserController::class,     "newemail"])->name(             "user.newemail");
Route::post(    "/user/changename",                     [UserController::class,     "changename"])->name(           "user.changename");
Route::post(    "/user/changetype",                     [UserController::class,     "changetype"])->name(           "user.changetype");
Route::post(    "/user/applyverification",              [UserController::class,     "applyverification"])->name(    "user.applyverification");
Route::post(    "/user/cancelverification",             [UserController::class,     "cancelverification"])->name(   "user.cancelverification");
Route::get(     "/post",                                [OfferController::class,    "create"])->name(               "offer.create");
Route::post(    "/post",                                [OfferController::class,    "insert"])->name(               "offer.insert");
Route::post(    "/offer/{offer}",                       [OfferController::class,    "interested"])->name(           "offer.interested");
Route::get(     "/user/offers",                         [UserController::class,     "offers"])->name(               "user.offers");
Route::post(    "/user/changeprofilepicture",           [UserController::class,     "changeprofilepicture"])->name( "user.changeprofilepicture");
Route::post(    "/user/deleteprofilepicture",           [UserController::class,     "deleteprofilepicture"])->name( "user.deleteprofilepicture");
});

Route::middleware(["auth", "verified", NotBanned::class, CompleteProfile::class, InterestedOrOwner::class])->group(function(){
Route::get(     "/offer/{offer}/chat",                  [OfferController::class,    "chat"])->name(                 "offer.chat");
Route::post(    "/offer/{offer}/chat",                  [OfferController::class,    "sendchat"])->name(             "offer.sendchat");
Route::get(     "/offer/{offer}/chat/proposal",         [OfferController::class,    "proposal"])->name(             "offer.proposal");
});

Route::middleware(["auth", "verified", NotBanned::class, CompleteProfile::class, Owner::class])->group(function(){
Route::get(     "/offer/{offer}/dashboard",             [OfferController::class,    "dashboard"])->name(            "offer.dashboard");
Route::post(    "/offer/{offer}/dashboard",             [OfferController::class,    "edit"])->name(                 "offer.edit");
Route::get(     "/offer/{offer}/dashboard/proposal",    [OfferController::class,    "previewproposal"])->name(      "offer.previewproposal");
Route::post(    "/offer/{offer}/dashboard/proposal",    [OfferController::class,    "editproposal"])->name(         "offer.editproposal");
Route::post(    "/offer/{offer}/chat/grantproposal",    [OfferController::class,    "grantproposal"])->name(        "offer.grantproposal");
Route::post(    "/offer/{offer}/chat/thank",            [OfferController::class,    "thank"])->name(                "offer.thank");
Route::post(    "/offer/{offer}/dashboard/delete",      [OfferController::class,    "delete"])->name(               "offer.delete");
});

Route::middleware(["auth", "verified", "signed", NotBanned::class, CompleteProfile::class])->group(function(){
Route::get(     "/user/changeemail",                    [UserController::class,     "changeemail"])->name(          "user.changeemail");
});

Route::middleware(["auth", "verified", NotBanned::class, CompleteProfile::class, Admin::class])->group(function(){
Route::get(     "/admin",                               [AdminController::class,    "index"])->name(                "admin.index");
Route::get(     "/admin/verifications",                 [AdminController::class,    "verifications"])->name(        "admin.verifications");
Route::post(    "/admin/verifications",                 [AdminController::class,    "verifyverification"])->name(   "admin.verifyverification");
Route::get(     "/admin/users",                         [AdminController::class,    "users"])->name(                "admin.users");
Route::post(    "/admin/users",                         [AdminController::class,    "usersedit"])->name(            "admin.usersedit");
Route::post(    "/admin/users/deleteverification",      [AdminController::class,    "deleteverification"])->name(   "admin.deleteverification");
Route::get(     "/admin/verifications/accessfile",      [AdminController::class,    "accessfile"])->name(           "admin.verifications.accessfile");
});
require __DIR__.'/auth.php';
