<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaUrl extends Model
{
    protected $fillable = [
        'url',
        'artist_id',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
