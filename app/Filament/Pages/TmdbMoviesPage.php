<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Movies2Resource\Pages\ListMovies2s;
use Filament\Pages\Page;

class TmdbMoviesPage extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'TMDB Movies';
    protected static ?string $slug = 'tmdb-movies';
    protected string $view = 'livewire.tmdb-movie-list';
//    protected static string $view = 'filament.pages.tmdb-movies-page';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' =>  ListMovies2s::route('/'),
            // 'edit' => Pages\EditStockReport::route('/{record}/edit'),
        ];
    }

}

