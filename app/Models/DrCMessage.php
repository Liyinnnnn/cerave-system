<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrCMessage extends Model
{
    protected $table = 'dr_c_messages';

    protected $fillable = [
        'user_id',
        'session_id',
        'message',
        'message_type',
        'response',
        'tokens_used',
        'skin_concerns',
        'recommended_products',
        'ip_address',
    ];

    protected $casts = [
        'recommended_products' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(DrCSession::class, 'session_id')->withDefault();
    }
}
