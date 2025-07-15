<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Entertainment;
use App\Models\Genres;
use App\Repositories\ApiRepository;
use App\Repositories\TMDBRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{

    protected ApiRepository $apiRepository;

    public function __construct()
     {
        $this->apiRepository = new ApiRepository();
     }

    public function categories(Request $request)
    {
      return $this->apiRepository->categories($request);
    }

    public function init(Request $request)
    {
        return $this->apiRepository->init($request);
    }

    public function collection(Request $request)
    {
        return $this->apiRepository->collection($request);
    }

    public function sliders(Request $request)
    {
        return $this->apiRepository->sliders($request);
    }

    public function genres(Request $request)
    {
      return $this->apiRepository->genres($request);
    }


    public function postData(Request $request)
    {
      $data = $request->data;
      foreach ($data as $genre) {
        // $genres =new  Genres();
        // $genres ->name =["ar" => $genre['name']['en'], "en" =>$genre['name']['en']];
        // $genres ->$genre['category_id'];
        // $genres ->$genre['tm_id'];
        // $genres->save()
        Genres::create([
           'name' =>["ar" => $genre['name']['en'], "en" =>$genre['name']['en']],
            'category_id' => 1,
            'tm_id' => $genre['id']
        ]);
    }


    }
    public function moviesAll(Request $request)
    {
        Log::debug("lsdkjfoweiurowier");
        return $this->apiRepository->moviesAll($request);
    }


    public function updateCheck(Request $request)
    {
      dd("asdfasdfasdf");

    }
    public function generateMovies(Request $request)
    {
      // ini_set('max_execution_time', 0); // 3600 seconds = 60 minutes
      // set_time_limit(0);
      // $uniqueNumbers = [];
      // $insertedCount = 4704;

      // while ($insertedCount < 500000) {
      //     $number = mt_rand(100000, 999999);

      //     // Check if the number already exists
      //     if (!Entertainment::where('tmdb_id', $number)->exists()) {
      //         // Store the unique number in the database
      //         Entertainment::create([
      //           'tmdb_id' => $number ,
      //         'adult' =>false,
      //         'media_type' =>  'movies',
      //         'title' =>  'title' ,
      //         'video' =>  false,
      //         'overview' =>  'overview' ,
      //         'genre_ids' => [5,7,8],
      //         'popularity' => 8.2,
      //         'vote_count' => 5.5,
      //         'poster_path' => 'poster_path',
      //         'release_date' =>  null,
      //         'vote_average' => 5.5,
      //         'backdrop_path' => 'backdrop_path',
      //         'original_title' => 'original_title',
      //         'original_language' => 'original_language',


      //       ]);
      //         $uniqueNumbers[] = $number;
      //         Log::debug($insertedCount);
      //         $insertedCount++;

      //     }
      // }


    }

    public function addToCart(Request $request)
    {

        return $this->apiRepository->addToCart($request);
    }

    public function deleteFromCart(Request $request)
    {

        return $this->apiRepository->deleteFromCart($request);
    }
    public function updateCart(Request $request)
    {

        return $this->apiRepository->updateCart($request);
    }
    public function getCart(Request $request)
    {

        return $this->apiRepository->getCart($request);
    }



}
