<?php

namespace App\Filament\Resources\SliderResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\SliderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlider extends EditRecord
{
    protected static string $resource = SliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
