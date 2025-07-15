<?php

namespace App\Filament\Resources\MoviesResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\MoviesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovies extends ListRecords
{
    protected static string $resource = MoviesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
