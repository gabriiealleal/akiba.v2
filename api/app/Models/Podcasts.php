<?php

namespace App\Models;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcasts extends Model
{
    use HasFactory;

    protected $table = 'podcasts';

    protected $filltable = [
        'slug',
        'author',
        'season',
        'episode',
        'title',
        'image',
        'resume',
        'content',
        'player',
        'aggregators',
    ];

    protected $casts = [
        'aggregators' => 'array',
    ];

    public function author()
    {
        return $this->hasOne(Users::class, 'id', 'author');
    }

}
