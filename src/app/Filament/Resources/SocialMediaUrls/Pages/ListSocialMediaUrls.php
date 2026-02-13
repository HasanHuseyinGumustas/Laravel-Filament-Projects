<?php

namespace App\Filament\Resources\SocialMediaUrls\Pages;

use App\Filament\Resources\SocialMediaUrls\SocialMediaUrlsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialMediaUrls extends ListRecords
{
    protected static string $resource = SocialMediaUrlsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
