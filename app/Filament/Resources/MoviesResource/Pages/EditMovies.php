<?php

namespace App\Filament\Resources\MoviesResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MoviesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovies extends EditRecord
{
    protected static string $resource = MoviesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
