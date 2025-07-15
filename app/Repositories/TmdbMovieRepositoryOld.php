<?php

namespace App\Repositories;

use App\Http\Resources\ApiResource;
use App\Http\Resources\ApiResourceWithOutResults;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class TmdbMovieRepositoryOld

{

    public $channel;
    protected $language;
    protected $page;
    protected $suffixRequestData;
    protected $suffixUrl;
    protected $prefixUrl;
    protected $moviesId;

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
        Log::debug('ddddddddddddddddddddddddddddd'.$request->page);
        Log::debug($request->prefixUrl);
        return $this;
    }

    public function setMoviesId($moviesId) :self
    {
        $this->moviesId=$moviesId ;
        return $this;
    }

    public function data(Request $request)
    {

        $body['language'] = $this->language !=null ? 'language='.$this->language: null;
        $body['page'] = $this->page!=null ?  'page='.$this->page : null;
        $body['append_to_response'] = $this->suffixRequestData !=null ? 'append_to_response='.$this->suffixRequestData : null;

        Log::debug($body);
        Log::debug($request->all());
        Log::debug($this->prefixUrl.'/'.$this->suffixUrl);
        $response =  TMDBService($this->prefixUrl, $request->all());

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
