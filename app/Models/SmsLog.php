<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'phone_number',
        'message',
        'type',
        'status',
        'sent_at',
        'response',
        'error_message',
        'retry_count',
        'context',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        // Cast as 'array' so Eloquent handles JSON encoding/decoding automatically.
        // NEVER pass json_encode() values into these fields — pass raw arrays directly.
        'response' => 'array',
        'context' => 'array',
    ];
}