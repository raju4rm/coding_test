<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'email',
    ];

    /* relation with user & user details */
    public function details()
    {
        return $this->hasOne(UserDetails::class, 'user_id', 'user_id');
    }

    /* relation with user & user location */

    public function location()
    {
        return $this->hasOne(UserLocation::class, 'user_id', 'user_id');
    }
}
