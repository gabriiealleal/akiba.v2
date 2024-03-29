<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'slug',
        'is_active',
        'login',
        'password',
        'access_levels',
        'avatar',
        'name',
        'nickname',
        'email',
        'age',
        'city',
        'state',
        'country',
        'biography',
        'social_networks',
        'likes'
    ];

    protected $casts = [
        'access_levels' => 'array',
        'social_networks' => 'array',
        'likes' => 'array'
    ];

    protected $hidden = [
        'login',
        'password'
    ];
    
}
