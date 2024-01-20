<?php

use App\Models\Show;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamingNow extends Model
{
    use HasFactory;

    protected $table = 'streaming_now';

    protected $fillable = [
        'show',
        'type',
        'start_streaming',
        'end_streaming'
    ];

    public function show()
    {
        return $this->hasOne(Show::class, 'id', 'show');
    }
}
