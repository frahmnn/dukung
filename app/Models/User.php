<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    public $incrementing = false;

    public function applicant(){
        return $this->hasOne(Verification::class, "id", "applicant");}

    public function verifiers(){
        return $this->hasMany(Verification::class, "id", "verifier");}

    public function offers(){
        return $this->hasMany(Offer::class, "id", "offer");}

    public function interestees(){
        return $this->hasMany(Chatroom::class, "id", "interestee");}

    public function froms(){
        return $this->hasMany(Chat::class, "id", "from");}

    public function users(){
        return $this->hasMany(Thank::class, "id", "users");}

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "id",
        'name',
        'email',
        'password',
        "role",
        "completeprofile",
        "organization"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
