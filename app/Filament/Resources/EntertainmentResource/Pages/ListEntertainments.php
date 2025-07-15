<?php

namespace App\Filament\Resources\EntertainmentResource\Pages;

//use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Actions\CreateAction;
use App\Filament\Resources\EntertainmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEntertainments extends ListRecords
{
    protected static string $resource = EntertainmentResource::class;
//    use Translatable;
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
