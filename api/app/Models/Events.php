<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'slug',
        'author',
        'location',
        'content'
    ];

    protected $casts = [
        'dates' => 'array'
    ];

    public function author()
    {
        return $this->hasOne(Users::class, 'id', 'author');
    }

}
