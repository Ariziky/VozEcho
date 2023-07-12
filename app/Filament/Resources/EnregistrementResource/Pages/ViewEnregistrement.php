<?php

namespace App\Filament\Resources\EnregistrementResource\Pages;

use App\Filament\Resources\EnregistrementResource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewEnregistrement extends ViewRecord
{
    protected static string $resource = EnregistrementResource::class;

    protected static ?string $title = 'Détails de l\'enregistrement';

    protected function form(Form $form): Form
    {
        return $form->schema([
            Card::make([
                Placeholder::make('created_at')
                    ->label('Date d\'enregistrement')
                    ->content($this->record->created_at->format('d/m/Y H:i')),

                Placeholder::make('ip_address')
                    ->label('Ip de l\'utilisateur')
                    ->content($this->record->ip_address),

                Placeholder::make('file_name')
                    ->label('Nom du fichier')
                    ->content(basename($this->record->path)),

                Placeholder::make('file_url')
                    ->label('Url du fichier')
                    ->content(asset($this->record->path)),
            ])
        ]);
    }
}
