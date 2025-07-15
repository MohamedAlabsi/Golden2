<?php

namespace App\Filament\Resources\AccountSettingResource\Pages;

use App\Filament\Resources\AccountSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAccountSetting extends CreateRecord
{
    protected static string $resource = AccountSettingResource::class;

    protected function handleRecordCreation(array $data): Model
{
    $data['user_id'] = auth()->id();
    return static::getModel()::create($data);
}
}
