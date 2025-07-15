<?php

namespace App\Filament\Resources\MovieCartResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\MovieCartResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovieCarts extends ListRecords
{
    protected static string $resource = MovieCartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
