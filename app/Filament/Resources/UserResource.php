<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?string $modelLabel = 'Utilisateur';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nom et prénom(s)')
                    ->required()
                    ->maxLength(50),

                TextInput::make('email')
                    ->label('Adresse mail')
                    ->required()
                    ->email(),

                Placeholder::make('created_at')
                    ->label('Date Création')
                    ->content(fn (?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom complet')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Adresse mail')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->date(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
