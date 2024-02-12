<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $filltable = [
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
