<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $incrementing = false;
    protected $table="notifications";
    protected $fillable=[
        "id",
        "user",
        "chatroom"
    ];
}
