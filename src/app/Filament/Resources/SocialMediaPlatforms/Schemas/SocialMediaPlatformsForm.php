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

                Textarea::make('icon_uri')
                    ->label('İkon (SVG Kodu)')
                    ->placeholder('<svg ...> ... </svg>')
                    ->rows(5)
                    ->required()
                    ->helperText('Platformun resmi SVG kodunu buraya yapıştırın.')
                    ->hint(fn ($state) => $state ? new HtmlString('<div style="width: 24px; height: 24px; color: orange;">' . $state . '</div>') : null),
            ]);
    }
}
