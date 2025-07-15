<?php

use App\Filament\Pages\TmdbMoviesPage;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\TmdbMovieController;
use Illuminate\Support\Facades\Route;

use App\Models\Genres;

Route::get('/api/genres', function () {
    $categoryId = request('category_id');
    if (!$categoryId) {
        return response()->json([]);
    }

    return response()->json(
        Genres::where('category_id', $categoryId)->pluck('name', 'tm_id')
    );
});
Route::get('/hi', function () {
    return 'welcome' ;
});
Route::get('/api/sort-options', function () {
    $categoryId = request('category_id');
    $options = \App\Models\SortOption::where('category_id', $categoryId)->get();
    $optionsArray = $options->pluck('name', 'key');
    $defaultOption = $options->firstWhere('is_default', true);
    $defaultKey = $defaultOption ? $defaultOption->key : null;

    return response()->json([
        'options' => $optionsArray,
        'default' => $defaultKey,
    ]);
});
Route::get('/movies', [TmdbMovieController::class, 'index'])->name('movies.index');
Route::get('/tmdb-movies', [TmdbMoviesPage::class, 'render'])->name('filament.pages.tmdb-movies');
Route::get('/generate_movies', [ApiController::class,"generateMovies"]);
Route::post('/update-check', [ApiController::class, 'updateCheck']);


