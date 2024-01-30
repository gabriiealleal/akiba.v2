<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicsList extends Model
{
    use HasFactory;

    protected $table = 'musics_list';

    protected $filltable = [
        'count',
        'music',
        'artist',
        'album',
    ];
}
