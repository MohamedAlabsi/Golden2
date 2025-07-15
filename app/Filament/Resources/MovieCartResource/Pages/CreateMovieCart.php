<?php

namespace App\Filament\Resources\MovieCartResource\Pages;

use App\Filament\Resources\MovieCartResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovieCart extends CreateRecord
{
    protected static string $resource = MovieCartResource::class;
}
