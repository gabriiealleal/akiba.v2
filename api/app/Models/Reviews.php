<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'slug',
        'author',
        'title',
        'image',
        'content',
    ];

    protected $casts = [
        'reviews' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'author');
    }
}
