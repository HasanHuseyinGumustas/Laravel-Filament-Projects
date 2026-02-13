<?php

namespace App\Filament\Resources\SocialMediaUrls;

use App\Filament\Resources\SocialMediaUrls\Pages\CreateSocialMediaUrls;
use App\Filament\Resources\SocialMediaUrls\Pages\EditSocialMediaUrls;
use App\Filament\Resources\SocialMediaUrls\Pages\ListSocialMediaUrls;
use App\Filament\Resources\SocialMediaUrls\Schemas\SocialMediaUrlsForm;
use App\Filament\Resources\SocialMediaUrls\Tables\SocialMediaUrlsTable;
use App\Models\SocialMediaUrls;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialMediaUrlsResource extends Resource
{
    protected static ?string $model = SocialMediaUrls::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'SocialMediaUrl';

    public static function form(Schema $schema): Schema
    {
        return SocialMediaUrlsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialMediaUrlsTable::configure($table);
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
            'index' => ListSocialMediaUrls::route('/'),
            'create' => CreateSocialMediaUrls::route('/create'),
            'edit' => EditSocialMediaUrls::route('/{record}/edit'),
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
