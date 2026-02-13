<?php

namespace App\Filament\Resources\ScrappedEvents\Pages;

use App\Filament\Resources\ScrappedEvents\ScrappedEventsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditScrappedEvents extends EditRecord
{
    protected static string $resource = ScrappedEventsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
