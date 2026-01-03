<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DrCSession extends Model
{
    protected $table = 'dr_c_sessions';

    protected $fillable = [
        'user_id',
        'session_token',
        'concerns',
        'report',
        'status',
        'message_count',
        'tokens_used',
        'ended_at',
    ];

    protected $casts = [
        'ended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DrCMessage::class, 'session_id');
    }

    /**
     * Generate a unique session token.
     */
    public static function generateToken(): string
    {
        return 'DRC_' . strtoupper(bin2hex(random_bytes(20)));
    }

    /**
     * End this session and mark as completed.
     */
    public function endSession(): void
    {
        $this->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);
    }

    /**
     * Get formatted session duration.
     */
    public function getSessionDurationAttribute(): string
    {
        $end = $this->ended_at ?? now();
        $duration = $end->diffInMinutes($this->created_at);

        if ($duration < 1) {
            return 'less than 1 min';
        } elseif ($duration < 60) {
            return "{$duration} min";
        } else {
            $hours = intdiv($duration, 60);
            $minutes = $duration % 60;
            return "{$hours}h {$minutes}m";
        }
    }

    /**
     * Get conversation summary.
     */
    public function getConversationSummary(): string
    {
        $messageCount = $this->messages()->count();
        $concerns = $this->concerns ?? 'General skincare';
        return "{$messageCount} messages about {$concerns}";
    }
}
