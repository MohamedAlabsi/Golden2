<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TmdbMovieRepository;
use App\Services\TmdbService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TmdbMovieController extends Controller
{
  private $request;
  protected TmdbMovieRepository $tmdbMovieRepository;

  public function __construct()
  {

    $this->tmdbMovieRepository = new TmdbMovieRepository();
  }

  public function popular(Request $request)
  {

    return $this->tmdbMovieRepository->setInitData($request,'movie/popular')->data($request);
  }
  // public function allPopular(Request $request)
  // {

  //   return $this->tmdbMovieRepository->setInitData($request)->popular($request);
  // }

  public function nowPlaying(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request,'movie/now_playing')->data($request);
  }

  public function upcoming(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request,'movie/upcoming')->data($request);
  }

  public function latest(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request,'movie/latest')->data($request);
  }


  public function topRated(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request,'movie/top_rated')->data($request);
  }

  // public function similar(Request $request)
  // {
  //   return $this->tmdbMovieRepository->setInitData($request)->setMoviesId($request->id)->similar($request);
  // }

  // public function recommendations(Request $request)
  // {
  //   return $this->tmdbMovieRepository->setInitData($request)->setMoviesId($request->id)->recommendations($request);
  // }

  // public function credits(Request $request)
  // {
  //   return $this->tmdbMovieRepository->setInitData($request)->setMoviesId($request->id)->credits($request);
  // }


  public function images(Request $request)
  {
    return $this->tmdbMovieRepository->setMoviesId($request->id)->images($request);
  }
  public function videos(Request $request)
  {
    return $this->tmdbMovieRepository->setMoviesId($request->id)->videos($request);
  }

  public function movieDetails(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request)->data($request);
  }

  public function entertainmentExtra(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request)->entertainmentExtra($request);
  }

  public function collectionEntertainments(Request $request)
  {
    return $this->tmdbMovieRepository->setInitData($request)->collectionEntertainments($request);
  }
  public function movies(Request $request)
  {
    Log::debug("lsdkjfoweiurowier");
    return $this->tmdbMovieRepository->setInitData($request)->data($request);
  }




  public function index(Request $request, TmdbService $tmdbService)
    {
        $query = $request->input('query', 'Inception'); // استعلام الفيلم الافتراضي
        $page = $request->input('page', 1); // الصفحة الحالية
        $response = $tmdbService->getMovies($query, $page); // جلب الأفلام من TMDB

        $total = $response['total_results']; // إجمالي النتائج
        $perPage = 20; // عدد العناصر لكل صفحة
        $items = collect($response['results']); // العناصر الحالية

        $paginator = new LengthAwarePaginator(
            $items, $total, $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('filament.pages.movies-page', compact('paginator'));
    }
}
