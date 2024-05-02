<?php

namespace App\Models;

use App\Models\Users;
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
        return $this->belongsTo(Users::class, 'addressee', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(Users::class, 'creator', 'id');
    }
}
