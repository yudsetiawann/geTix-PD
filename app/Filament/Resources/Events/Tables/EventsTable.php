<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('location')->searchable(),
                // TextColumn::make('ticket_price')->money('IDR')->sortable(),
                TextColumn::make('starts_at')->dateTime('d M Y')->sortable()->label('Mulai'),
                TextColumn::make('ends_at')->dateTime('d M Y')->sortable()->label('Selesai'),
                TextColumn::make('ticket_sold')->label('Terjual')->numeric()->sortable(),
                TextColumn::make('ticket_quota')->label('Sisa Kuota')->numeric()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
