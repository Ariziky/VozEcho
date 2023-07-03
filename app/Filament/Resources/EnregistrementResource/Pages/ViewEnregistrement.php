<?php

namespace App\Filament\Resources\EnregistrementResource\Pages;

use App\Filament\Resources\EnregistrementResource;
use Filament\Resources\Pages\ViewRecord;

class ViewEnregistrement extends ViewRecord
{
    protected static string $resource = EnregistrementResource::class;

    protected static ?string $title = 'Consultation enregistrement';
}
