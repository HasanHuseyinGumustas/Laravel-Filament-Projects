<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Filament\Resources\Locations\LocationResource;
use App\Models\District;
use App\Models\Event;
use App\Models\Location;
use App\Models\Province;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
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
                                Grid::make(3)->schema([
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
                                Action::make('createLocation')
                                    ->label('Yeni Konum Ekle')
                                    ->icon('heroicon-o-map-pin')
                                    ->modalHeading('Yeni Konum Oluştur')
                                    ->modalSubmitActionLabel('Oluştur')
                                    ->modalWidth('7xl')
                                    ->schema(fn() => LocationResource::form(
                                        app(\Filament\Schemas\Schema::class)
                                    )->getComponents())
                                    ->action(function (array $data, Set $set) {
                                        $location = Location::create($data);

                                        $set('location_id', $location->id);
                                    }),

                                Select::make('location_id')
                                    ->label('Konum')
                                    ->relationship('location', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                DateTimePicker::make('started_at')
                                    ->label('Başlangıç Tarihi')
                                    ->seconds(false)
                                    ->required(),

                                DateTimePicker::make('ended_at')
                                    ->label('Bitiş Tarihi')
                                    ->seconds(false)
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

                                    TextInput::make('purchase_link')
                                        ->label('Satın Alma Linki')
                                        ->url(),

                                    Toggle::make('is_commentable')
                                        ->label('Yorumlara İzin Ver')
                                        ->default(true),
                                ]),
                            ]),
                    ]),
            ]);
    }
}
