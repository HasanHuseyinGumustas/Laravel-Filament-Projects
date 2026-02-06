<?php

namespace App\Observers;

use App\Models\VisibilityType as Model;

class VisibilityTypeObserver
{
    public function creating(Model $model): void
    {
    }
}
