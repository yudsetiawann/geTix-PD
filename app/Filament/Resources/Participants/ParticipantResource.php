<?php

// namespace App\Filament\Resources\Participants;

// use UnitEnum;
// use BackedEnum;
// use Filament\Tables\Table;
// use App\Models\Participant;
// use Filament\Schemas\Schema;
// use Filament\Resources\Resource;
// use Filament\Support\Icons\Heroicon;
// use Illuminate\Support\Facades\Auth;
// use App\Filament\Resources\Participants\Pages\EditParticipant;
// use App\Filament\Resources\Participants\Pages\ListParticipants;
// use App\Filament\Resources\Participants\Pages\CreateParticipant;
// use App\Filament\Resources\Participants\Schemas\ParticipantForm;
// use App\Filament\Resources\Participants\Tables\ParticipantsTable;

// class ParticipantResource extends Resource
// {
//     protected static ?string $model = Participant::class;
//     protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
//     protected static ?string $navigationLabel = 'Manajemen Anggota';
//     protected static string|UnitEnum|null $navigationGroup = 'Data Anggota';
//     protected static ?string $recordTitleAttribute = 'name';

//     public static function form(Schema $schema): Schema
//     {
//         return ParticipantForm::configure($schema);
//     }

//     public static function table(Table $table): Table
//     {
//         return ParticipantsTable::configure($table);
//     }

//     public static function getRelations(): array
//     {
//         return [
//             //
//         ];
//     }

//     public static function getPages(): array
//     {
//         return [
//             'index' => ListParticipants::route('/'),
//             'create' => CreateParticipant::route('/create'),
//             'edit' => EditParticipant::route('/{record}/edit'),
//         ];
//     }

//     public static function canViewAny(): bool
//     {
//         // Hanya izinkan jika user adalah admin
//         return Auth::user()->isAdmin();
//     }
// }
