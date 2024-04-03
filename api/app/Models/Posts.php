<?php

namespace App\Models;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'slug',
        'author',
        'featured_image',
        'image',
        'title',
        'content',
    ];

    protected $casts = [
        'categories' => 'array',
        'search_fonts' => 'array',
        'reactions' => 'array'
    ];

    public function author()
    {
        return $this->hasOne(Users::class, 'id', 'author');
    }


}
