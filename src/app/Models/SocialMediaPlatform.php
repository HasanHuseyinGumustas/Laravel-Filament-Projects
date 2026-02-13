<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaPlatform extends Model
{
    protected $fillable = [
        'name',
        'icon_uri',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
