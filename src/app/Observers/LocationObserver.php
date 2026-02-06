<?php

namespace App\Observers;

use App\Models\Location as Model;

class LocationObserver
{
    public function creating(Model $model): void
    {
    }
}
