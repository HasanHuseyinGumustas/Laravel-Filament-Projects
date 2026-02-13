<?php

namespace App\Filament\Resources\SocialMediaPlatforms\Pages;

use App\Filament\Resources\SocialMediaPlatforms\SocialMediaPlatformsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialMediaPlatforms extends ListRecords
{
    protected static string $resource = SocialMediaPlatformsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
