<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'birthday',
        'gender',
        'phone',
        'country_code',
        'profile_picture',
        'password',
        'role',
        'skin_type',
        'skin_concerns',
        'skin_conditions',
        'using_products',
        'skincare_profile_updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'using_products' => 'array',
            'skincare_profile_updated_at' => 'datetime',
        ];
    }

    public function activities()
    {
        return $this->hasMany(\App\Models\Activity::class);
    }

    public function getProfileImageUrlAttribute(): ?string
    {
        if (!empty($this->profile_picture)) {
            return asset('storage/profile_pictures/' . $this->profile_picture);
        }
        return null;
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function drCSessions()
    {
        return $this->hasMany(DrCSession::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isConsultant(): bool
    {
        return $this->role === 'consultant';
    }

    public function isConsumer(): bool
    {
        return $this->role === 'consumer';
    }
}
