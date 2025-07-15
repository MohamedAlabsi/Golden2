<?php

namespace App\Filament\Resources\CollectionMoviesResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\CollectionMoviesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollectionMovies extends EditRecord
{
    protected static string $resource = CollectionMoviesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
