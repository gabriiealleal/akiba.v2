<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListenerOfTheMonth extends Model
{
    use HasFactory;

    protected $table = 'listener_of_the_month';

    protected $fillable = [
        'name',
        'address',
        'avatar',
        'requests',
        'favorite_show'
    ];
}
