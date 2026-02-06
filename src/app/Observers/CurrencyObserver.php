<?php

namespace App\Observers;

use App\Models\Currency as Model;

class CurrencyObserver
{
    public function creating(Model $model): void
    {
    }
}
