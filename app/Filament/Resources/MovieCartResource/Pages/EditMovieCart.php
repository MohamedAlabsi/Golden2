<?php

namespace App\Filament\Resources\MovieCartResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MovieCartResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovieCart extends EditRecord
{
    protected static string $resource = MovieCartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
