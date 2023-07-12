<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationLabel = 'Utilisateurs';

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?string $modelLabel = 'Utilisateur';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return User::query()->withoutSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')
                        ->label('Nom et prénom(s)')
                        ->required()
                        ->maxLength(50),

                    TextInput::make('email')
                        ->label('Adresse mail')
                        ->required()
                        ->email(),

                    TextInput::make('password')
                        ->label('Mot de passe')
                        ->required()
                        ->password()
                        ->minLength(8),

                    TextInput::make('passwordConfirmation')
                        ->label('Confirmation mot de passe')
                        ->required()
                        ->password()
                        ->same('password')
                        ->dehydrated(false),
                ])->columnSpan(3),

                Card::make([
                    Placeholder::make('created_at')
                        ->label('Date Création')
                        ->content(fn(?User $record): ?string => $record?->created_at?->format('d/m/Y H:i:s')),

                    Placeholder::make('created_at')
                        ->label('Date Création')
                        ->disableLabel()
                        ->content(fn(?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                ])->columnSpan(1),
            ])->columns(4);
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
                    ->label('Date création')
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
