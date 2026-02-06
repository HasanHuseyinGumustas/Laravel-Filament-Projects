<?php

namespace App\Models;

use App\Observers\NeighborhoodObserver as Observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Neighborhood extends Model
{
    use HasFactory, QueryCacheable, LogsActivity, SoftDeletes;

    protected $fillable = [
        'district_id',
        'name',
        'postal_code',
    ];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\District::class);
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
