<?php

namespace App\Models;

use App\Observers\EventCategoryObserver as Observer;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EventCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, QueryCacheable, LogsActivity, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'photoURL',
    ];

    public function getPhotoUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('photo', 'original');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function addMedia(string|UploadedFile $file): FileAdder
    {
        [$width, $height] = getimagesize($file);
        $ratio = round($width / $height, 2);

        return app(FileAdderFactory::class)->create($this, $file)
            ->withCustomProperties(['width' => $width, 'height' => $height, 'ratio' => $ratio]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->storeConversionsOnDisk(config('media-library.conversion_disk_name'))
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('original')
                    ->format('webp');

                $this->addMediaConversion('560x320')
                    ->fit(Fit::Contain, 560, 320)
                    ->format('webp');
            });
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
