<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserDetails extends Authenticatable
{
    protected $table = 'user_details';
    protected $primaryKey = 'user_detail_id';
    
    /* relation with user details and user */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }    
}
