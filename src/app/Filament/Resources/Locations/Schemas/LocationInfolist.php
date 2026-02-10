<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Models\Location;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LocationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('province.name')
                    ->label('Province')
                    ->placeholder('-'),
                TextEntry::make('district_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('ref_id')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('address'),
                TextEntry::make('latitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('google_maps_uri')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Location $record): bool => $record->trashed()),
            ]);
    }
}
