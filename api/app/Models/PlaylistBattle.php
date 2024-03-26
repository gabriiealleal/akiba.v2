<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistBattle extends Model
{
    use HasFactory;

    protected $table = 'playlist_battle';

    protected $fillable = [
        'image',
    ];

}
