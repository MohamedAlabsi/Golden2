<?php

namespace App\Filament\Resources\MohammedResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MohammedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMohammed extends EditRecord
{
    protected static string $resource = MohammedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
