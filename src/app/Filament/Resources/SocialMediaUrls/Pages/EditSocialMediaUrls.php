<?php

namespace App\Filament\Resources\SocialMediaUrls\Pages;

use App\Filament\Resources\SocialMediaUrls\SocialMediaUrlsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialMediaUrls extends EditRecord
{
    protected static string $resource = SocialMediaUrlsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
