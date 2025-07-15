<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\Genres;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $data['name'] = [
//            'ar' => $data['name_ar'] ?? '',
//            'en' => $data['name_en'] ?? '',
//        ];
//
//        unset($data['name_ar'], $data['name_en']);
//
//        return $data;
//    }





}
