<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Exception;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Consultation utilisateur';

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
