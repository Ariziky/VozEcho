<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnregistrementResource\Pages;
use App\Models\Enregistrement;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class EnregistrementResource extends Resource
{
    protected static ?string $model = Enregistrement::class;

    protected static ?string $slug = 'audios';

    protected static ?string $navigationLabel = 'Historique';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('path')
                        ->required(),

                    TextInput::make('size')
                        ->required()
                        ->integer(),

                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn (?Enregistrement $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('path'),

                TextColumn::make('size'),

                TextColumn::make('extension'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnregistrements::route('/'),
            'view' => Pages\ViewEnregistrement::route('/{record}'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
