<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mtvs\EloquentApproval\Approvable;
use Mtvs\EloquentApproval\ApprovalScope;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Event extends Model implements HasMedia
{
    use Approvable, HasFactory, InteractsWithMedia, LogsActivity, Sluggable, SoftDeletes;

    protected $fillable = [
        'visibility_type_id',
        'event_category_id',
        'currency_id',
        'location_id',
        'is_online',
        'title',
        'started_at',
        'ended_at',
        'price',
        'purchase_link',
        'person_capacity',
        'description',
        'is_commentable',
        'commission_rate',
    ];

    protected $appends = [
        'photoURL',
    ];

    protected $hidden = [
        'commission_rate',
    ];

    protected $casts = [
        'price' => 'float',
        'commission_rate' => 'float',
        'is_commentable' => 'boolean',
        'is_online' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('photos', 'original') ?: $this->eventCategory?->photoURL;
    }

    public function visibilityType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\VisibilityType::class);
    }

    public function eventCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\EventCategory::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class);
    }

    public function scopeWithoutBlockedUser($query): void
    {
        if (auth()->check()) {
            $query->whereDoesntHave('user.subscriptions', function ($query) {
                $query->whereNot('user_id', auth()->user()->id);
            });
        }
    }

    public function scopeOrganizerAwareDateFilter(Builder $query, string $field, string $operator, Carbon $dateValue): Builder
    {
        return $query->where(function (Builder $query) use ($field, $operator, $dateValue) {
            $query->whereNull('organizer_id')
                ->where($field, $operator, $dateValue);

            $query->orWhere(function (Builder $q) use ($field, $operator, $dateValue) {
                $q->whereNotNull('organizer_id')
                    ->whereHas('occurrences', function (Builder $occurrenceQuery) use ($field, $operator, $dateValue) {
                        $occurrenceQuery->where($field, $operator, $dateValue);
                    });
            });
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true,
                'maxLength' => 255,
            ],
        ];
    }

    /**
     * eloquent-sluggable için benzersizlik kontrol sorgusunu override eder.
     */
    public function scopeFindSimilarSlugs(Builder $query, string $attribute, array $config, string $slug): Builder
    {
        $query = $query->withoutGlobalScopes([
            ApprovalScope::class,
            SoftDeletingScope::class,
        ]);

        $separator = $config['separator'] ?? '-';

        return $query->where(function (Builder $q) use ($attribute, $slug, $separator) {
            $q->where($attribute, $slug)
                ->orWhere($attribute, 'LIKE', $slug . $separator . '%');
        });
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
        /**
         * storeConversionsOnDisk metoduna verilen config değeri null dönüyordu.
         * config('media-library.disk_name') veya varsayılan olarak 'public' ekleyerek hatayı giderdik.
         */
        $this->addMediaCollection('photos')
            ->storeConversionsOnDisk(config('media-library.disk_name', 'public'))
            ->registerMediaConversions(function (Media $media) {
                $conversion = $this->addMediaConversion('original')
                    ->format('webp');

                if ($media->hasCustomProperty('width') && $media->getCustomProperty('width') < 320) {
                    $conversion->width(320);
                }

                if ($media->hasCustomProperty('width') && $media->getCustomProperty('width') > 1080) {
                    $conversion->width(1080);
                }

                $conversion->withResponsiveImages();
            });
    }

    public function approvalNotRequired(): array
    {
        return array_keys($this->getAttributes());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->getConnectionName())
            ->logAll()
            ->logOnlyDirty();
    }

    public function getCommissionRateAttribute($value): float
    {
        if (!is_null($value)) {
            return (float) $value;
        }

        return (float) config('organizer.default_commission_rate', 10.0);
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->commission_rate)) {
                $model->commission_rate = null;
            }
        });

    }
}
