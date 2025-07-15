<?php

namespace App\Filament\Resources\OriginalLanguageResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\OriginalLanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOriginalLanguages extends ListRecords
{
    protected static string $resource = OriginalLanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
