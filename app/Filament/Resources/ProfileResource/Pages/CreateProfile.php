<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;



// protected function handleRecordCreation(array $data): Model
// {
//     $data['user_id'] = auth()->id();
//     return static::getModel()::create($data);
// }

}
