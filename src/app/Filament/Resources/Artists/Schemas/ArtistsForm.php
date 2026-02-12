<?php

namespace App\Filament\Resources\Artists\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;



class ArtistsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn(string $operation, $state) => $operation === 'create'
                            ? $state
                            : null
                    )
                    ->maxLength(255),

                Repeater::make('SocialMediaUrl')
                    ->label('Sosyal Medya Hesapları')
                    ->relationship()
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('social_media_platform')
                                ->label('Platform')
                                ->required(),

                            TextInput::make('url')
                                ->label('URL')
                                ->url()
                                ->required(),
                        ]),
                    ])
                    ->addActionLabel('Yeni Sosyal Medya Ekle')
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
