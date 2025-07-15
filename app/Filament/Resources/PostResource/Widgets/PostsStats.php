<?php

namespace App\Filament\Resources\PostResource\Widgets;

use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
 
class PostsStats extends Widget implements HasForms
{
    use InteractsWithForms;
 
    protected string $view = 'livewire.tmdb-movie-list';
    // protected static string $view = 'filament.resources.contact-resource.widgets.create-contact-widget';
 
    protected int | string | array $columnSpan = 'full';
 
    public ?array $data = [];
 
    public function mount(): void
    {
        $this->form->fill();
    }
 
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
            ])
            ->statePath('data');
    }
}
