<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Etkinlik Başlığı')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('eventCategory.name')
                    ->label('Kategori')
                    ->placeholder('Kategori Yok'),

                TextColumn::make('started_at')
                    ->label('Başlangıç')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('approval_status')
                    ->label('Durum')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
