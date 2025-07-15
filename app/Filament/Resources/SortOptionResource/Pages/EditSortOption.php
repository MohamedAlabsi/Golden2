<?php

namespace App\Filament\Resources\SortOptionResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\SortOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSortOption extends EditRecord
{
    protected static string $resource = SortOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
