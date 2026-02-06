<?php

namespace App\Observers;

use App\Models\Region as Model;
use Illuminate\Support\Str;

class RegionObserver
{
    public function saving(Model $model): void
    {
        if ($model->getOriginal('name') !== $model->getAttribute('name')) {
            $model->name = Str::trUcWords(Str::multipleSpaceClear(trim($model->name)));
        }
    }
}
