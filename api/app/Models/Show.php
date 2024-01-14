<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $table = 'shows';

    protected $filltable = [
        'slug',
        'presenter',
        'name',
        'logo'
    ];

    public function presenter()
    {
        return $this->hasOne(User::class, 'id', 'presenter');
    }
}
