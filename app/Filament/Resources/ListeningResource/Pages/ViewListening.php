<?php

namespace App\Filament\Resources\ListeningResource\Pages;

use App\Filament\Resources\ListeningResource;
use Filament\Resources\Pages\ViewRecord;

class ViewListening extends ViewRecord
{
    protected static string $resource = ListeningResource::class;

    protected static ?string $title = 'Détails de l\'enregistrement';
}
