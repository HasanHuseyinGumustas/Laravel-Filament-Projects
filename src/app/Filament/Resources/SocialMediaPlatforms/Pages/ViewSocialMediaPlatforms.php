<?php

namespace App\Filament\Resources\SocialMediaPlatforms\Pages;

use App\Filament\Resources\SocialMediaPlatforms\SocialMediaPlatformsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSocialMediaPlatforms extends ViewRecord
{
    protected static string $resource = SocialMediaPlatformsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
