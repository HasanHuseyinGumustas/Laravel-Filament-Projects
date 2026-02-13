<?php

namespace App\Filament\Resources\ScrappedEvents\Pages;

use App\Filament\Resources\ScrappedEvents\ScrappedEventsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScrappedEvents extends ListRecords
{
    protected static string $resource = ScrappedEventsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
