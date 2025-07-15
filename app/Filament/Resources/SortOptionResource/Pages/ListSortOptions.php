<?php

namespace App\Filament\Resources\SortOptionResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SortOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSortOptions extends ListRecords
{
    protected static string $resource = SortOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
