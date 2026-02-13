<?php

namespace App\Filament\Resources\ScrappedEvents;

use App\Filament\Resources\ScrappedEvents\Pages\CreateScrappedEvents;
use App\Filament\Resources\ScrappedEvents\Pages\EditScrappedEvents;
use App\Filament\Resources\ScrappedEvents\Pages\ListScrappedEvents;
use App\Filament\Resources\ScrappedEvents\Schemas\ScrappedEventsForm;
use App\Filament\Resources\ScrappedEvents\Tables\ScrappedEventsTable;
use App\Models\ScrappedEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScrappedEventsResource extends Resource
{
    protected static ?string $model = ScrappedEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ScrappedEvents';

    public static function form(Schema $schema): Schema
    {
        return ScrappedEventsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScrappedEventsTable::configure($table);
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
            'index' => ListScrappedEvents::route('/'),
            'create' => CreateScrappedEvents::route('/create'),
            'edit' => EditScrappedEvents::route('/{record}/edit'),
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
