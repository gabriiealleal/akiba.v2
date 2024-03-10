<?php

namespace App\Models;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamCalendar extends Model
{
    use HasFactory;

    protected $table = 'team_calendar';

    protected $fillable  = [
        'category',
        'responsible',
        'content',
    ];

    public function responsible()
    {
        return $this->hasOne(Users::class, 'id', 'responsible');
    }
}
