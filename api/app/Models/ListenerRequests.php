<?php

namespace App\Models;

use App\Models\MusicsList;
use App\Models\StreamingNow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListenerRequests extends Model
{
    use HasFactory;

    protected $table = 'listener_requests';

    protected $fillable = [
        'listener',
        'address',
        'message',
        'streaming',
        'music'
    ];

    public function streaming()
    {
        return $this->hasOne(StreamingNow::class, 'id', 'streaming');
    }

    public function music()
    {
        return $this->hasOne(MusicsList::class, 'id', 'music');
    }
}
