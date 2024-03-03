<?php

namespace App\Models;

use App\Models\Users;
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
        return $this->hasOne(Users::class, 'id', 'author');
    }
}
