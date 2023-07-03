<?php

namespace App\Filament\Resources\EnregistrementResource\Pages;

use App\Filament\Resources\EnregistrementResource;
use Filament\Resources\Pages\ListRecords;

class ListEnregistrements extends ListRecords
{
    protected static string $resource = EnregistrementResource::class;

    protected static ?string $title = 'Historique';
}
