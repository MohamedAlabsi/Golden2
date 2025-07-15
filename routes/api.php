<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiTMDBController;
use App\Http\Controllers\Api\ApiTMDBControllerMovie;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TmdbMovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);


});

//Route::get('/sort-options', function () {
//    $categoryId = request('category_id');
//
//    $options = SortOption::where('category_id', $categoryId)->get();
//
//    return response()->json([
//        'options' => $options->pluck('name', 'key'),
//        'default' => optional($options->firstWhere('is_default', true))->key,
//    ]);
//});

Route::name("movie")->prefix("movie")->group(function ($router) {
    Route::post('/popular', [TmdbMovieController::class,"popular"]);
    Route::post('/now_playing', [TmdbMovieController::class,"nowPlaying"]);
    Route::post('/upcoming', [TmdbMovieController::class,"upcoming"]);
    Route::post('/latest', [TmdbMovieController::class,"latest"]);
    Route::post('/top_rated', [TmdbMovieController::class,"topRated"]);
    Route::post('/similars', [TmdbMovieController::class,"similar"]);
    Route::post('/recommendations', [TmdbMovieController::class,"recommendations"]);
    Route::post('/credits', [TmdbMovieController::class,"credits"]);

    Route::post('/images', [TmdbMovieController::class,"images"]);
    Route::post('/videos', [TmdbMovieController::class,"videos"]);

    Route::post('/movie_details', [TmdbMovieController::class,"movieDetails"]);
    Route::post('/entertainment_extra', [TmdbMovieController::class,"entertainmentExtra"]);
    Route::post('/collection_entertainments', [TmdbMovieController::class,"collectionEntertainments"]);
    Route::post('/', [TmdbMovieController::class,"movies"]);
});

//Route::name("tv")->prefix("tv")->group(function ($router) {
//    Route::post('/popular', [TmdbMovieController::class,"popular"]);
//    Route::post('/now_playing', [TmdbMovieController::class,"nowPlaying"]);
//    Route::post('/upcoming', [TmdbMovieController::class,"upcoming"]);
//    Route::post('/latest', [TmdbMovieController::class,"latest"]);
//    Route::post('/top_rated', [TmdbMovieController::class,"topRated"]);
//    Route::post('/similars', [TmdbMovieController::class,"similar"]);
//    Route::post('/recommendations', [TmdbMovieController::class,"recommendations"]);
//    Route::post('/credits', [TmdbMovieController::class,"credits"]);
//
//    Route::post('/images', [TmdbMovieController::class,"images"]);
//    Route::post('/videos', [TmdbMovieController::class,"videos"]);
//
//    Route::post('/movie_details', [TmdbMovieController::class,"movieDetails"]);
//    Route::post('/', [TmdbMovieController::class,"tv"]);
//});

Route::name("search")->prefix("search")->group(function ($router) {
    Route::post('/all', [ApiController::class,"moviesAll"]);
});

Route::name("api")->group(function ($router) {
    Route::get('/init', [ApiController::class,"init"]);
    Route::get('/sliders', [ApiController::class,"sliders"]);
    Route::get('/collection', [ApiController::class,"collection"]);
    Route::get('/genres', [ApiController::class,"genres"]);
    Route::post('/post_data', [ApiController::class,"postData"]);
    Route::post('/post_data', [ApiController::class,"postData"]);



});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/movie-cart/add', [ApiController::class, 'addToCart']);
    Route::post('/movie-cart/get', [ApiController::class, 'getCart']);
    Route::post('/movie-cart/delete', [ApiController::class, 'deleteFromCart']);
    Route::post('/movie-cart/update', [ApiController::class, 'updateCart']);

});
