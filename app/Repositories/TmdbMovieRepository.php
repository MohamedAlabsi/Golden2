<?php

namespace App\Repositories;

use App\Enums\TypeRequest;
use App\Http\Resources\ApiAllResource;
use App\Http\Resources\ApiResource;
use App\Http\Resources\ApiResourceWithOutResults;
use App\Models\Entertainment;
use App\Models\EntertainmentExtra;
use App\Models\EntertainmentsDetails;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class TmdbMovieRepository

{

  public $channel;
  protected $language;
  protected $page;
  protected $suffixRequestData;
  protected $suffixUrl;
  protected $prefixUrl;
  protected $moviesId;
  protected TypeRequest $typeRequest;

  public function __construct()
  {

  }

  public function setInitData(Request $request) :self
  {
    $this->language=$request->language  ;
    $this->page=$request->page ;
    $this->suffixRequestData=$request->suffix_request_data ;
    // $this->suffixUrl=$suffixUrl;
    $this->prefixUrl=$request->prefixUrl;

      if (  ($request->has('type_request') && $request->type_request === TypeRequest::Details->value)
      ) {
          $this->typeRequest = TypeRequest::Details;
      } else {
          $this->typeRequest = TypeRequest::Other;
      }
    return $this;
  }

  public function setMoviesId($moviesId) :self
  {
    $this->moviesId=$moviesId ;
    return $this;
  }

  public function data(Request $request)
  {
      if ($this->typeRequest === TypeRequest::Details) {
          $id = Str::after($this->prefixUrl, '/');
          $movie = EntertainmentsDetails::where('tmdb_id', $id)->first();
          if($movie){
              return  new  ApiResource( $movie->details);
          }

      }
      Log::debug('stop mohammed');
    $body['language'] = $this->language !=null ? 'language='.$this->language: null;

    $page = request()->query('page', 1);
    $body['page'] = $page;
//      $body['page'] = $this->page!=null ?  'page='.$this->page : null;



//      $body['append_to_response'] = $this->suffixRequestData !=null ? 'append_to_response='.$this->suffixRequestData : null;

//    Log::debug($body);
//    Log::debug($request->all());
//    Log::debug('prefixUrl = '.$this->prefixUrl.'/ and suffixUrl = '.$this->suffixUrl);

      $setting = Setting::first();
      $TMDB_ENABLE = $setting->key['tmdb_enable'] ;
      Log::debug('TMDB_ENABLE is '.$TMDB_ENABLE);


      if(!$TMDB_ENABLE ){
          if(!$request->has('discover_type') &&  !($request->has('type_request') && $request->type_request='details')){
              $query = Entertainment::query();
              Log::debug('with_genres with_genres = '.($request->with_genres));
              if ($request->filled('with_genres') && (int) $request->with_genres !== 0) {
                  $genreId = (int) $request->with_genres;
                  $query->whereJsonContains('genre_ids', $genreId);
              }
              if ($request->filled('with_original_language') && $request->with_original_language != null) {
                  $query->where('original_language', $request->with_original_language);
              }
              $query->where('media_type_id', $request->media_type_id);
              $entertainments = $query->paginate(20);
              return  new  ApiAllResource($entertainments);
          }

            if($request->has('discover_type')){

                $query = Entertainment::query();
                if ($request->filled('with_genres') && $request->with_genres !== 0) {
                    $genreId = (int) $request->with_genres;
                    $query->whereJsonContains('genre_ids', $genreId);
                }
                if ($request->filled('with_original_language') && $request->with_original_language != null) {
                    $query->where('original_language', $request->with_original_language);
                }

              if ($request->input('discover_type') == 'tv') {
                  Log::debug('hhhhhhhhhhhhhhhhhhhh hi tv');
                  $entertainments = $query->where('media_type','tv')->paginate(20);
              } else {
                  Log::debug('hhhhhhhhhhhhhhhhhhhh hi movies');
                  $entertainments = $query->whereNot('media_type','tv')->paginate(20);
              }
              return  new  ApiAllResource($entertainments);
          }
      }

      $response =  TMDBService($this->prefixUrl, $request->all());
      Log::debug('stop stop00000');
      Log::debug($this->typeRequest->value);
      if ($this->typeRequest === TypeRequest::Details) {
          $id = Str::after($this->prefixUrl, '/');
          Log::debug('stop stop00000');
          Log::debug($request->prefixUrl);
          Log::debug( $response->json());
          EntertainmentsDetails::create([
              'tmdb_id' => $id,
              'details' => $response->json(),
          ]);;
      }




    //     return $response;
    //     $filteredData = array_map(function ($item) {

    //           return [
    //             'adult' => $item['adult']
    //             'backdrop_path' => $item['backdrop_path']
    //             'genre_ids' => $item['genre_ids']
    //             'id' => $item['id']
    //             'original_language' => $item['original_language']
    //             'original_title' => $item['original_title']
    //             'overview' => $item['overview']
    //             'popularity' => $item['popularity']
    //             'poster_path' => $item['poster_path']
    //             'release_date' => $item['release_date']
    //           ];

    //   }, $response['results']);

    //   $result = [
    //     "page" => $response['page'],
    //     "results" => array_values($filteredData), // استخدم array_values لإعادة تهيئة المفاتيح
    //     "total_pages" => $response['total_pages'],
    //     "total_results" => $response['total_results'],
    // ];

    return  new  ApiResource($response->json());
  }


    public function collectionEntertainments(Request $request)
    {
        Log::debug('hhhhhhhhhhhhhhhhhhhh hi movies');
                $query = Entertainment::query();

                if ($request->type == 'tv') {
                     $entertainments = $query->where('media_type','tv')->where('is_top_series',true)->paginate(20);
                } else {
                    Log::debug('hhhhhhhhhhhhhhhhhhhh hi movies');
                    $entertainments = $query->whereNot('media_type','tv')->where('is_top_movie',true)->paginate(20);
                }
                return  new  ApiAllResource($entertainments);


    }


    public function entertainmentExtra(Request $request)
    {

        $movie = EntertainmentExtra::where('entertainment_id', $request->id)->first();

        if ($movie) {
            Log::debug("ddddddddddddddddddddddddddddd");
            Log::debug($movie->collection);
        }

        $entertainments = Entertainment::where('media_type_id', 1)
            ->whereNotNull('collection_id')
            ->where('collection_id', $movie?->collection)
            ->where('id', '!=', $request->entertainment_id)
            ->orderBy('release_date')
            ->get();

        return new ApiAllResource([
            'entertainmentExtra' => $movie,
            'movie' => $entertainments,
        ]);

        $prefix = $request->media_type_id == 2 ? 'tv' : 'movie';
        $tmdbId = $request->tmdb_id;

        $url = "{$prefix}/{$tmdbId}";
        $body['append_to_response'] = 'append_to_response=videos,credits,reviews,images';
        Log::debug('tesdddddddddddddt');
        $body['prefixUrl'] = $url;
        Log::debug($body);

        $response = TMDBService($url, $body);
        Log::debug($response->json());

        if ($response->successful()) {
            $data = $response->json();

            EntertainmentExtra::updateOrCreate(
                ['entertainment_id' => $request->id],
                [
                    'videos' => collect($data['videos']['results'] ?? [])->take(5)->values(),
                    'cast' =>  collect($data['credits']['cast'] ?? [])
                ->filter(fn ($person) => isset($person['character']) && $person['character'] !== '')
                ->take(10)
                ->values(),
                    'reviews' => collect($data['reviews']['results'] ?? [])->take(6)->values(),
                    'images' => [
                        'posters' => collect($data['images']['posters'] ?? [])->take(4)->values(),
                        'backdrops' => collect($data['images']['backdrops'] ?? [])->take(4)->values(),
                    ],
                    'collection' => $data['belongs_to_collection']['id'] ?? null,

                    'seasons' =>   null,
//                    'seasons' => $request->media_type_id == 2 ? ($data['seasons'] ?? null) : null,
                ]
            );
        }

        return  new  ApiResource($response->json());
    }
    public function moviesAll(Request $request)
    {




        return  new  ApiResource( );
    }

  public function allPopular(Request $request)
  {

    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/popular', $body);


    return  new  ApiResource($response);
  }

  public function nowPlaying(Request $request)
  {
    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/now_playing', $body);
    return  new  ApiResource($response);
  }

  public function upcoming(Request $request)
  {
    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/upcoming', $body);
    return  new  ApiResource($response);
  }

  public function latest(Request $request)
  {
    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/latest', $body);

    return  new  ApiResourceWithOutResults($response);
  }

  public function topRated(Request $request)
  {
    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/top_rated', $body);
    return  new  ApiResource($response);
  }


  public function similar(Request $request)
  {

    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/'.$this->moviesId.'/similar', $body);
    return  new  ApiResource($response);
  }

  public function recommendations(Request $request)
  {
    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/'.$this->moviesId.'/recommendations', $body);
    return  new  ApiResource($response);
  }

  public function credits(Request $request)
  {
    $body['language'] = $this->language;
    $body['page='] = $this->page;
    $response =  TMDBService('movie/'.$this->moviesId.'/credits', $body);
    return  new  ApiResource(['results'=>$response['cast']]);
  }

  public function images(Request $request)
  {

    $response =  TMDBService('movie/'.$this->moviesId.'/images', []);

    return  new  ApiResourceWithOutResults($response);
  }
  public function videos(Request $request)
  {
    $response =  TMDBService('movie/'.$this->moviesId.'/videos', []);
    return  new  ApiResourceWithOutResults(['backdrops'=>$response['results']]);
  }







  public function save($interest = null)
  {
  }

  public function confirm($send_id = null, $loan_id = null, $interest = null, $responsLoan = null)
  {
  }

  public function reject()
  {
  }

  public function cancel($id = null)
  {
  }
}
