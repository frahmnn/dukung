<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    public $incrementing = false;

    public function interestee(){
        return $this->belongsTo(User::class, "interestee");}

    public function chatrooms(){
        return $this->hasMany(Chatroom::class, "id", "chatroom");}
        
    protected $table="chatrooms";
    protected $fillable=[
        "id",
        "offer",
        "interestee",
        "grantproposal"
    ];
}
