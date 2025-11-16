<?php

namespace App\Filament\Resources\Participants\Tables;

use Filament\Tables\Table;
use App\Models\Participant;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('school')->label('Ranting/Sekolah')->searchable()->sortable(),
                TextColumn::make('level')->label('Tingkatan')->searchable()->sortable(),
                TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter dinamis berdasarkan data unik dari database
                SelectFilter::make('school')
                    ->label('Ranting/Sekolah')
                    ->options(
                        static fn() => Participant::query()
                            ->select('school')
                            ->distinct()
                            ->orderBy('school')
                            ->pluck('school', 'school')
                            ->toArray()
                    )
                    ->getOptionLabelUsing(fn($value) => $value)
                    ->searchable(),

                SelectFilter::make('level')
                    ->label('Tingkatan')
                    ->options(
                        static fn() => Participant::query()
                            ->select('level')
                            ->distinct()
                            ->orderBy('level')
                            ->pluck('level', 'level')
                            ->toArray()
                    )
                    ->getOptionLabelUsing(fn($value) => $value)
                    ->searchable(),
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
