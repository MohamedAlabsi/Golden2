<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\CategoryResource;
use App\Models\Genres;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
