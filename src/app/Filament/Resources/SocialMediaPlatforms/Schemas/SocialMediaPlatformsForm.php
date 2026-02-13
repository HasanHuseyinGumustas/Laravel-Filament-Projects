<?php

namespace App\Filament\Resources\SocialMediaPlatforms\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class SocialMediaPlatformsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Platform Adı')
                    ->placeholder('Örn: Instagram, LinkedIn')
                    ->required()
                    ->maxLength(255),

                TextInput::make('icon_uri')
                    ->label('İkon Url')
                    ->placeholder('Örn: https://example.com/icon.svg')
                    ->required()
            ]);
    }
}
