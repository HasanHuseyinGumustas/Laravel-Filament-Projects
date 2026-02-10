<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Models\District;
use App\Models\Event;
use App\Models\Location;
use App\Models\Province;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->columns(1)
            ->components([
                Wizard::make()
                    ->maxWidth('7xl')
                    ->schema([
                        Wizard\Step::make('Etkinlik Detayları')
                            ->columnSpanFull()
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('title')
                                        ->label('Başlık')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(
                                            fn(string $operation, $state, Set $set) => $operation === 'create'
                                                ? $set('slug', Str::slug($state))
                                                : null
                                        )
                                        ->maxLength(255),

                                    TextInput::make('slug')
                                        ->required()
                                        ->unique(Event::class, 'slug', ignoreRecord: true)
                                        ->maxLength(255),

                                    Select::make('event_category_id')
                                        ->label('Kategori')
                                        ->relationship('eventCategory', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    Select::make('visibility_type_id')
                                        ->label('Görünürlük')
                                        ->relationship('visibilityType', 'name')
                                        ->preload()
                                        ->required(),
                                ]),
                            ]),

                        Wizard\Step::make('Konum ve Tarih')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Select::make('search_location')
                                    ->label('Google Haritalarda Ara')
                                    ->placeholder('Mekan adı veya adres yazın...')
                                    ->searchable()
                                    ->getSearchResultsUsing(function (string $search) {
                                        if (strlen($search) < 3) return [];

                                        $response = Http::get("https://api.aqtivite.com.tr/locations/search", [
                                            'query' => $search
                                        ]);

                                        if ($response->failed()) return [];

                                        return collect($response->json())
                                            ->mapWithKeys(fn ($item) => [
                                                json_encode($item) => $item['name'] . ' - ' . ($item['address'] ?? '')
                                            ])
                                            ->toArray();
                                    })
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if (!$state) return;

                                        $data = json_decode($state, true);

                                        $set('name', $data['name'] ?? null);
                                        $set('ref_id', $data['ref_id'] ?? $data['id'] ?? null);
                                        $set('address', $data['address'] ?? null);
                                        $set('latitude', $data['latitude'] ?? null);
                                        $set('longitude', $data['longitude'] ?? null);
                                        $set('google_maps_uri', $data['google_maps_uri'] ?? null);
                                    })
                                    ->columnSpanFull()
                                    ->helperText('Arama yaptıktan sonra bir mekan seçerseniz aşağıdaki alanlar otomatik dolar.'),

                                Grid::make(3)->schema([
                                    TextInput::make('name')
                                        ->label('Mekan Adı')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('ref_id')
                                        ->label('Google Referans ID')
                                        ->maxLength(255),
                                ])->columns(2),

                                Grid::make(2)->schema([
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

                                    TextInput::make('address')
                                        ->label('Açık Adres')
                                        ->required()
                                        ->maxLength(500),
                                ]),

                                TextInput::make('google_maps_uri')
                                    ->label('Google Haritalar Linki')
                                    ->url()
                                    ->columnSpanFull(),

                                Grid::make(2)->schema([
                                    TextInput::make('latitude')
                                        ->label('Enlem')
                                        ->numeric(),

                                    TextInput::make('longitude')
                                        ->label('Boylam')
                                        ->numeric(),
                                ]),

                                DatePicker::make('started_at')
                                    ->label('Başlangıç Tarihi')
                                    ->required(),

                                DatePicker::make('ended_at')
                                    ->label('Bitiş Tarihi')
                                    ->required(),
                            ]),

                        Wizard\Step::make('Açıklama ve Medya')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                RichEditor::make('description')
                                    ->label('Açıklama')
                                    ->columnSpanFull()
                                    ->nullable(),

                                SpatieMediaLibraryFileUpload::make('photo')
                                    ->label('Fotoğraf')
                                    ->collection('photos')
                                    ->image()
                                    ->imageEditor()
                                    ->nullable(),
                            ]),

                        Wizard\Step::make('Ayarlar')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('price')
                                        ->label('Fiyat')
                                        ->numeric()
                                        ->nullable(),

                                    Select::make('currency_id')
                                        ->label('Para Birimi')
                                        ->relationship('currency', 'id')
                                        ->preload(),

                                    TextInput::make('person_capacity')
                                        ->label('Kapasite')
                                        ->numeric()
                                        ->suffix('Kişi'),

                                    Grid::make(2)->schema([
                                        TextInput::make('purchase_link')
                                            ->label('Satın Alma Linki')
                                            ->url(),

                                        TextInput::make('commission_rate')
                                            ->label('Komisyon Oranı (%)')
                                            ->numeric()
                                            ->default(fn() => config('organizer.default_commission_rate', 10.0)),
                                    ]),

                                    Toggle::make('is_commentable')
                                        ->label('Yorumlara İzin Ver')
                                        ->default(true),
                                ]),
                            ]),
                    ]),
            ]);
    }
}
