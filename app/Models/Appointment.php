<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'preferred_date',
        'preferred_time',
        'consultation_type',
        'location',
        'concerns',
        'solution',
        'ai_suggestion',
        'consultant_notes',
        'suggested_products',
        'usage_instructions',
        'purchased_products',
        'status',
        'completed_at',
        'user_id',
        'consultant_id',
        'report_status',
        'report_submitted_at',
        'report_submitted_by',
        'report_approved_at',
        'report_approved_by',
        'admin_feedback',
        'skin_assessment',
        'recommended_products',
        'skincare_advice',
        'lifestyle_tips',
        'report_generated_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'completed_at' => 'datetime',
        'report_submitted_at' => 'datetime',
        'report_approved_at' => 'datetime',
        'recommended_products' => 'array',
        'report_generated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consultant_id')->withDefault();
    }

    public function reportSubmitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_submitted_by')->withDefault();
    }

    public function reportApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_approved_by')->withDefault();
    }
}
