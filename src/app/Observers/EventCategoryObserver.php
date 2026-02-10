<?php

namespace App\Observers;

use App\Models\EventCategory as Model;

class EventCategoryObserver
{
    public function creating(Model $model): void
    {
    }
}
