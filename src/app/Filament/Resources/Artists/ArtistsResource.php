<?php

namespace App\Filament\Resources\Artists;

use App\Filament\Resources\Artists\Pages\CreateArtists;
use App\Filament\Resources\Artists\Pages\EditArtists;
use App\Filament\Resources\Artists\Pages\ListArtists;
use App\Filament\Resources\Artists\Pages\ViewArtists;
use App\Filament\Resources\Artists\Schemas\ArtistsForm;
use App\Filament\Resources\Artists\Schemas\ArtistsInfolist;
use App\Filament\Resources\Artists\Tables\ArtistsTable;
use App\Models\Artist;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtistsResource extends Resource
{
    protected static ?string $model = Artist::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::MusicalNote;

    protected static ?string $navigationLabel = 'Sanatçılar';

    protected static ?string $recordTitleAttribute = 'Artist';

    public static function form(Schema $schema): Schema
    {
        return ArtistsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ArtistsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArtistsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArtists::route('/'),
            'create' => CreateArtists::route('/create'),
            'view' => ViewArtists::route('/{record}'),
            'edit' => EditArtists::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
