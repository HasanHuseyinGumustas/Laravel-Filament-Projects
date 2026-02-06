<?php

namespace App\Models;

use App\Observers\RegionObserver as Observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Region extends Model
{
    use HasFactory, QueryCacheable, LogsActivity, SoftDeletes;

    protected $connection = 'common';

    protected $fillable = [
        'country_id',
        'name',
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    public function provinces(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(\App\Models\Province::class);
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

        parent::observe(Observer::class);
    }
}
