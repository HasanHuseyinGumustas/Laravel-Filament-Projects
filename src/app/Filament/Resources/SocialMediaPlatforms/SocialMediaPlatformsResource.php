<?php

namespace App\Filament\Resources\SocialMediaPlatforms;

use App\Filament\Resources\SocialMediaPlatforms\Pages\CreateSocialMediaPlatforms;
use App\Filament\Resources\SocialMediaPlatforms\Pages\EditSocialMediaPlatforms;
use App\Filament\Resources\SocialMediaPlatforms\Pages\ListSocialMediaPlatforms;
use App\Filament\Resources\SocialMediaPlatforms\Pages\ViewSocialMediaPlatforms;
use App\Filament\Resources\SocialMediaPlatforms\Schemas\SocialMediaPlatformsForm;
use App\Filament\Resources\SocialMediaPlatforms\Schemas\SocialMediaPlatformsInfolist;
use App\Filament\Resources\SocialMediaPlatforms\Tables\SocialMediaPlatformsTable;
use App\Models\SocialMediaPlatform;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialMediaPlatformsResource extends Resource
{
    protected static ?string $model = SocialMediaPlatform::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Sosyal Medya Platformları';

    protected static ?string $recordTitleAttribute = 'SocialMediaPlatforms';

    public static function form(Schema $schema): Schema
    {
        return SocialMediaPlatformsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SocialMediaPlatformsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialMediaPlatformsTable::configure($table);
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
            'index' => ListSocialMediaPlatforms::route('/'),
            'create' => CreateSocialMediaPlatforms::route('/create'),
            'view' => ViewSocialMediaPlatforms::route('/{record}'),
            'edit' => EditSocialMediaPlatforms::route('/{record}/edit'),
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
