<?php

namespace App\Models;

use App\Observers\ProvinceObserver as Observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Province extends Model
{
    use HasFactory, QueryCacheable, LogsActivity, SoftDeletes;

    protected $fillable = [
        'region_id',
        'license_plate_code',
        'name',
    ];

    protected $table = 'provinces';

    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Region::class);
    }

    public function districts(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(\App\Models\District::class);
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
