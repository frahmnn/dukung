<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    public $incrementing = false;

    public function applicant(){
        return $this->belongsTo(User::class, "applicant");}

    public function verifier(){
        return $this->belongsTo(User::class, "verifier");}

    protected $table="verifications";
    protected $fillable=[
        "id",
        "applicant",
        "verifier",
        "status"
    ];
}
