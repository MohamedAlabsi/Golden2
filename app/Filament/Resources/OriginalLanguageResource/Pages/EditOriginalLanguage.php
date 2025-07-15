<?php

namespace App\Filament\Resources\OriginalLanguageResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\OriginalLanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOriginalLanguage extends EditRecord
{
    protected static string $resource = OriginalLanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
