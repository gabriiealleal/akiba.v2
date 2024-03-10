<?php

namespace App\Models;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shows extends Model
{
    use HasFactory;

    protected $table = 'shows';

    protected $fillable = [
        'slug',
        'presenter',
        'name',
        'logo'
    ];

    public function presenter()
    {
        return $this->hasOne(Users::class, 'id', 'presenter');
    }
}
