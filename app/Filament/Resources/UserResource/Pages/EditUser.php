<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Exception;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getTitle(): string|Htmlable
    {
        return 'Editer utilisateur : '.$this->record->name;
    }

    /**
     * @throws Exception
     */
    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->size('sm'),
        ];
    }
}
