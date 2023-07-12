<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnregistrementResource\Pages;
use App\Filament\Resources\EnregistrementResource\RelationManagers\ListeningsRelationManager;
use App\Models\Enregistrement;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class EnregistrementResource extends Resource
{
    protected static ?string $model = Enregistrement::class;

    protected static ?string $slug = 'records';

    protected static ?string $navigationLabel = 'Historique';

    protected static ?string $recordTitleAttribute = 'uuid';

    public static function getEloquentQuery(): Builder
    {
        return Enregistrement::query()->withCount('listenings')->latest();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date de lecture')
                    ->dateTime(),

                TextColumn::make('ip_address')
                    ->label('Ip de l\'utilisateur'),

                TextColumn::make('path')
                    ->label('Nom du fichier')
                    ->formatStateUsing(fn($state) => basename($state)),

                TextColumn::make('listenings_count')
                    ->label('Nombre de lectures')
                    ->formatStateUsing(fn($state) => basename($state)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnregistrements::route('/'),
            'view' => Pages\ViewEnregistrement::route('/{record}'),
        ];
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
