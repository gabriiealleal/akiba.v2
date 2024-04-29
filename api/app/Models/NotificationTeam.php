<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTeam extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'notification_team';

    protected $fillable = [
        'creator',
        'addressee',
        'content',
    ];

    public function addressee()
    {
        return $this->hasOne(Users::class, 'id', 'addressee');
    }

    public function creator()
    {
        return $this->hasOne(Users::class, 'id', 'creator');
    }
}
