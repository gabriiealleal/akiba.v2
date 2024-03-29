<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Top10Musics extends Model
{
    use HasFactory;

    protected $table = 'top_10_musics';

    protected $fillable = [
        'number_of_requests',
        'avatar',
        'name',
        'anime',
    ];

}
