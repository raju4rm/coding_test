<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserLocation extends Authenticatable
{
    protected $table = 'user_location';
    protected $primaryKey = 'user_location_id';
    
    /* relation with user location and user */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
