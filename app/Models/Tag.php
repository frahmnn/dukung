<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $incrementing = false;

    public function offer(){
        return $this->belongsTo(Offer::class, "offer");}
        
    protected $table="tags";
    protected $fillable=[
        "id",
        "tag",
        "offer"
    ];
}
