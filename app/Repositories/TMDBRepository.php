<?php

namespace App\Repositories;

use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
class TMDBRepository
{
    
    public $channel;
 

    public function __construct()
  {
    
  }

    public function movie_popular(Request $request)
    {
    
      $body['language']="ar";

    $response =  TMDBService('movie/popular',$body);

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
     return  new  ApiResource($response); 
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
