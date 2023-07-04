<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListeningResource\Pages;
use App\Models\Listening;
use Exception;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;

class ListeningResource extends Resource
{
    protected static ?string $model = Listening::class;

    protected static ?string $slug = 'listenings';

    protected static ?string $navigationLabel = 'Historique';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Placeholder::make('created_at')
                        ->label('Date de lecture')
                        ->content(fn(Listening $record): string => $record->created_at->format('d/m/Y H:i')),

                    Placeholder::make('ip_address')
                        ->label('Ip de l\'utilisateur')
                        ->content(fn(Listening $record): string => $record->ip_address),

                    Placeholder::make('file_name')
                        ->label('Nom du fichier')
                        ->content(fn(Listening $record): string => basename($record->enregistrement->path)),

                    Placeholder::make('file_url')
                        ->label('Url du fichier')
                        ->content(fn(Listening $record): string => asset($record->enregistrement->path)),
                ])
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date de lecture')
                    ->dateTime(),

                TextColumn::make('ip_address')
                    ->label('Ip de l\'utilisateur'),

                TextColumn::make('enregistrement.path')
                    ->label('Nom du fichier')
                    ->formatStateUsing(fn($state) => basename($state)),
            ])
            ->actions([
                ViewAction::make()->iconButton()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListListenings::route('/'),
            'view' => Pages\ViewListening::route('/{record}'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
