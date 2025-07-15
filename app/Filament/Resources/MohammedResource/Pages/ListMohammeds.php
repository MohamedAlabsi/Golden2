<?php

namespace App\Filament\Resources\MohammedResource\Pages;

use App\Filament\Resources\MohammedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

namespace App\Filament\Resources\MohammedResource\Pages;

use Filament\Resources\Pages\Page;

class ListMohammeds extends Page
{
    protected static string $resource = 'App\Filament\Resources\MohammedResource';
    protected string $view = 'filament.pages.list-mohammeds';
}
