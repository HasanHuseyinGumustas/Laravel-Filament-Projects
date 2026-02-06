<?php

namespace App\Models;

use App\Observers\MediaObserver as Observer;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;

class Media extends Model
{
    use QueryCacheable;

    protected $appends = [
        'original_url',
        'preview_url',
        'srcset',
    ];

    public function getSrcsetAttribute(): array
    {
        $items = [];
        foreach ($this->responsive_images as $key => $value) {
            $items[$key] = $this->getSrcset($key);
        }

        return $items;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->getConnectionName())
            ->logAll()
            ->logOnlyDirty();
    }

    public static function boot(): void
    {
        parent::boot();

        static::observe(Observer::class);
    }
}
