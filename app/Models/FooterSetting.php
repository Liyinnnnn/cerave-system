<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'description',
        'facebook_url',
        'instagram_url',
        'tiktok_url',
        'youtube_url',
        'address',
        'phone',
        'email',
        'copyright_text',
    ];
}
