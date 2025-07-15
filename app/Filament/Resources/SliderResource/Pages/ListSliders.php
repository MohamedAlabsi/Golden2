<?php

namespace App\Filament\Resources\SliderResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SliderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSliders extends ListRecords
{
    protected static string $resource = SliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    
}
