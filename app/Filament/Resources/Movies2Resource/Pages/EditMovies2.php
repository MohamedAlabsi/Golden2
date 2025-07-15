<?php

namespace App\Filament\Resources\Movies2Resource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Movies2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovies2 extends EditRecord
{
    protected static string $resource = Movies2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
