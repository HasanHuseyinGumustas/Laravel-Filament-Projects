<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaUrl extends Model
{
    protected $fillable = [
        'social_media_platform_id',
        'url',
    ];

    public function socialMediaPlatform()
    {
        return $this->belongsTo(SocialMediaPlatform::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
