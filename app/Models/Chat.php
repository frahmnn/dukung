<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public $incrementing = false;

    public function from(){
        return $this->belongsTo(User::class, "from");}

    public function chatroom(){
        return $this->belongsTo(Chatroom::class, "chatroom");}
        
    protected $table="chats";
    protected $fillable=[
        "id",
        "from",
        "chatroom",
        "message"
    ];
}
