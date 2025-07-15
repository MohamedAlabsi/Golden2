<?php

namespace App\Filament\Resources\EntertainmentResource\Pages;

//use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Filament\Actions\CreateAction;
use App\Filament\Resources\EntertainmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Spatie\Translatable\HasTranslations;

class ViewEntertainments extends ListRecords
{
    protected static string $resource = EntertainmentResource::class;
//    use HasTranslations;
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
