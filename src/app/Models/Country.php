<?php

namespace App\Models;

use App\Observers\CountryObserver as Observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    use HasFactory, QueryCacheable, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'country_code',
        'internet_code',
        'un_code',
        'un_number',
        'calling_code',
        'license_plate_code',
    ];

    public function regions(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(\App\Models\Region::class);
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
