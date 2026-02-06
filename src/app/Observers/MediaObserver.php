<?php

namespace App\Observers;

use App\Models\Media as Model;

class MediaObserver
{
    public function creating(Model $model): void
    {
    }
}
