<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Schemas\Components;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mtvs\EloquentApproval\ApprovalScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Etkinlikler';
    protected static ?string $recordTitleAttribute = 'Event';

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Etkinlik Bilgileri')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Başlık'),
                        TextEntry::make('slug')
                            ->label('Slug'),
                        TextEntry::make('is_online')
                            ->label('Çevrimiçi mi?')
                            ->formatStateUsing(fn(bool $state): string => $state ? 'Evet' : 'Hayır'),
                        TextEntry::make('location_id')
                            ->label('Konum'),
                        TextEntry::make('started_at')
                            ->label('Başlangıç Tarihi')
                            ->dateTime(),
                        TextEntry::make('ended_at')
                            ->label('Bitiş Tarihi')
                            ->dateTime(),
                        TextEntry::make('price')
                            ->label('Fiyat'),
                        TextEntry::make('person_capacity')
                            ->label('Kapasite'),
                        TextEntry::make('is_commentable')
                            ->label('Yorumlara izin ver?')
                            ->formatStateUsing(fn(bool $state): string => $state ? 'Evet' : 'Hayır'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return  EventsTable::configure($table);
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
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
                ApprovalScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
                ApprovalScope::class,
            ]);
    }
}
