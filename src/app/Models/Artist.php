<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'social_media_url_id',
    ];

    public function socialMediaUrl()
    {
        return $this->belongsTo(SocialMediaUrl::class);
    }
}
