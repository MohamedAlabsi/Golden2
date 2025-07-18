<?php

namespace App\Filament\Resources\GenreResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGenre extends EditRecord
{
    protected static string $resource = GenreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
