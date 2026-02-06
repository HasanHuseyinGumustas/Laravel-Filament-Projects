<?php

namespace App\Observers;

use App\Models\Neighborhood as Model;
use Illuminate\Support\Str;

class NeighborhoodObserver
{
    public function saving(Model $model): void
    {
        if ($model->getOriginal('name') !== $model->getAttribute('name')) {
            $model->name = Str::multipleSpaceClear(trim($model->name));
        }
    }
}
