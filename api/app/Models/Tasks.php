<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'responsible',
        'content',
        'status'
    ];

    public function responsible()
    {
        return $this->hasOne(Users::class, 'id', 'responsible');
    }
}
