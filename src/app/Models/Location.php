<?php

namespace App\Models;

use App\Observers\LocationObserver as Observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Location extends Model
{
    use HasFactory, QueryCacheable, LogsActivity, SoftDeletes;

    protected $table = 'locations';

    protected $fillable = [
        'id',
        'ref_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'google_maps_uri',
        'province_id',
        'district_id',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(Observer::class);
    }


    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Province::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->getConnectionName())
            ->logAll()
            ->logOnlyDirty();
    }
}
