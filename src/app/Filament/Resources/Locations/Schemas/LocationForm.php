<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Models\District;
use App\Models\Province;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Select::make('search_location')
                    ->label('Google Haritalarda Ara')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search): array {
                        if (strlen($search) < 3) {
                            return [];
                        }

                        $response = Http::get(
                            'https://api.aqtivite.com.tr/locations/search',
                            ['query' => $search]
                        );

                        if ($response->failed()) {
                            return [];
                        }

                        return collect($response->json('data'))
                            ->mapWithKeys(fn($item) => [
                                $item['id'] => $item['name'] . ' - ' . $item['address'],
                            ])
                            ->toArray();
                    })
                    ->getOptionLabelUsing(function ($value): ?string {
                        if (!$value) {
                            return null;
                        }

                        $location = Http::get(
                            "https://api.aqtivite.com.tr/locations/{$value}"
                        )->json('data');

                        return $location['name'] . ' - ' . $location['address'];
                    })
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set) {
                        if (!$state) {
                            return;
                        }

                        $location = Http::get(
                            "https://api.aqtivite.com.tr/locations/{$state}"
                        )->json('data');

                        $set('name', $location['name'] ?? null);
                        $set('ref_id', $location['ref_id'] ?? null);
                        $set('address', $location['address'] ?? null);
                        $set('latitude', $location['latitude'] ?? null);
                        $set('longitude', $location['longitude'] ?? null);
                        $set('google_maps_uri', $location['google_maps_uri'] ?? null);
                    })
                    ->columnSpanFull()
                    ->helperText('Arama yaptıktan sonra bir mekan seçerseniz aşağıdaki alanlar otomatik dolar.'),

                Grid::make(3)->schema([
                    TextInput::make('name')
                        ->label('Mekan Adı')
                        ->required()
                        ->maxLength(255),

                    Select::make('province_id')
                        ->label('İl')
                        ->options(Province::pluck('name', 'id'))
                        ->searchable()
                        ->live()
                        ->required(),

                    Select::make('district_id')
                        ->label('İlçe')
                        ->options(fn(callable $get) => District::where('province_id', $get('province_id'))->pluck('name', 'id')
                        )
                        ->searchable()
                        ->nullable(),
                ]),

                Textarea::make('address')
                    ->label('Açık Adres')
                    ->required()
                    ->maxLength(500),

                Grid::make(2)->schema([
                    TextInput::make('latitude')
                        ->label('Enlem')
                        ->numeric(),

                    TextInput::make('longitude')
                        ->label('Boylam')
                        ->numeric(),
                ]),
            ]);
    }
}
