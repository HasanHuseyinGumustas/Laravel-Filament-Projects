<?php

namespace App\Filament\Resources\SocialMediaPlatforms\Pages;

use App\Filament\Resources\SocialMediaPlatforms\SocialMediaPlatformsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialMediaPlatforms extends EditRecord
{
    protected static string $resource = SocialMediaPlatformsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
