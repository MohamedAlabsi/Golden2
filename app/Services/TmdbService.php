<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Year;
use App\Models\Years;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' =>config('services.tmdb.api') ,
        ]);
    }

    public function getMovies($query, $page = 1)
    {
        $response = $this->client->get('discover/movie' , [
            'query' => [
                'api_key' => config('services.tmdb.token'),
//                'with_original_language' => 'ar',
//                'language' => 'ar',
                'page' => $page,

            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getData($query, $page = 1,$categoryFilter ,$yearFilter , $typeFilter,$searchFilter,$genresFilter)
    {
        $url = 'discover/movie';
        $query =  [
                'api_key' => config('services.tmdb.token'),
                'include_adult' => 'false',
                'language' => 'en-US',
                'page' => $page,

        ];
        if($searchFilter!=null){
            $url = 'search/multi';
            $query['query'] =   $searchFilter;
        }
        else {
            if($categoryFilter !=null){
                switch ($categoryFilter) {
                    case '1':
                        $url = 'discover/movie';
                        break;

                    default:
                    $url = 'discover/tv';

                        break;
                }
            }
             if ($yearFilter!=null){
                 $query[($categoryFilter!=null && $categoryFilter!=1) ? 'first_air_date_year'   :'primary_release_year' ] = $yearFilter;
//                $query['first_air_date_year'] = '2023';
             }
            if ($genresFilter){
                $query['with_genres'] = $genresFilter;
            }
            if ($typeFilter){
                $query['with_original_language'] = $typeFilter;
            }

        }
        $query['sort_by'] =($categoryFilter !=null && $categoryFilter!=1) ? 'first_air_date.desc' : 'popularity.desc';
        $response = $this->client->get($url, [
            'query' => $query,
        ]);
        return json_decode($response->getBody(), true);
    }

    public function getDataFilter($query, $page = 1,$categoryFilter ,$yearFilter , $typeFilter,$searchFilter,$genresFilter, $sortBy)
    {
        $url = 'discover/movie'; // الافتراضي
        $query = [
            'api_key' => config('services.tmdb.token'),
            'include_adult' => 'false',
            'page' => $page,
            'with_watch_monetization_types' => 'flatrate,free,ads,rent,buy',
        ];

// الحالة: يوجد بحث
        if ($searchFilter !== null) {
            $url = match($categoryFilter) {
                '1' => 'search/movie',
                '2' => 'search/tv',
                default => 'search/multi',
            };

            $query['query'] = $searchFilter;

            // إذا لم يتم تحديد سنة، استخدم تاريخ اليوم كحد أقصى
            $today = date('Y-m-d');
            if ($yearFilter === null) {
                if ($categoryFilter === '2') {
                    $query['first_air_date.lte'] = $today;
                } elseif ($categoryFilter === '1') {
                    $query['primary_release_date.lte'] = $today;
                }
            } else {
                // تحديد مدى السنة كاملة (من 1 يناير إلى 31 ديسمبر)
                if ($categoryFilter === '2') {
                    $query['first_air_date.gte'] = $yearFilter . '-01-01';
                    $query['first_air_date.lte'] = $yearFilter . '-12-31';
                } elseif ($categoryFilter === '1') {
                    $query['primary_release_date.gte'] = $yearFilter . '-01-01';
                    $query['primary_release_date.lte'] = $yearFilter . '-12-31';
                }
            }
        }

// الحالة: تصفح عادي بدون بحث
        else {
            $url = $categoryFilter === '2' ? 'discover/tv' : 'discover/movie';

            $today = date('Y-m-d');
            if ($yearFilter !== null) {
                if ($categoryFilter === '2') {
                    $query['first_air_date.gte'] = $yearFilter . '-01-01';
                    $query['first_air_date.lte'] = $yearFilter . '-12-31';
                } else {
                    $query['primary_release_date.gte'] = $yearFilter . '-01-01';
                    $query['primary_release_date.lte'] = $yearFilter . '-12-31';
                }
            } else {
                // منع إظهار نتائج من المستقبل
                if ($categoryFilter === '2') {
                    $query['first_air_date.lte'] = $today;
                } else {

                    $query['primary_release_date.lte'] = $today;
                }
            }

            // الفلاتر الأخرى
            if (!empty($genresFilter)) {
                $query['with_genres'] = $genresFilter;
            }

            if (!empty($typeFilter)) {
                $query['with_original_language'] = $typeFilter;
            }

            if (!empty($sortBy)) {
                $query['sort_by'] = $sortBy;
            }
        }

// (اختياري) لتصحيح مشاكل غير متوقعة
        $query['language'] = 'en-US';

        Log::info(json_encode($query));
        $response = $this->client->get($url, ['query' => $query]);

        return json_decode($response->getBody(), true);
    }
}
