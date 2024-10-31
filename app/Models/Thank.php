<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thank extends Model
{
    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class, "user");}
    public function offer(){
        return $this->belongsTo(Offer::class, "offer");}
        
    protected $table="thanks";
    protected $fillable=[
        "id",
        "user",
        "offer"
    ];
}
