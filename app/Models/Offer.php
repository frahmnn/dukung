<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public $incrementing = false;

    public function applicant(){
        return $this->belongsTo(User::class, "applicant");}

    public function tags(){
        return $this->hasMany(Tag::class, "id", "tags");}
        
    protected $table="offers";
    protected $fillable=[
        "id",
        "name",
        "applicant",
        "description",
        "closed_date"
    ];
}