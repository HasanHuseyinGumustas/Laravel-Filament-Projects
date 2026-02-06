<?php

namespace App\Models;

use App\Observers\CurrencyObserver as Observer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    use HasFactory, QueryCacheable, LogsActivity;

    protected $fillable = [
        'no',
        'code',
        'name',
    ];

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
