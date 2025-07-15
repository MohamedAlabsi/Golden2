<?php

use Carbon\Carbon;
use App\Models\City;
use App\Models\Country;
use App\Models\Entertainment;
use App\User;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use App\Models\GroupingStatus;
use App\Models\Modification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

function resourceJson($json, $message, $status, $token = null)
{

  return [
    'data' => [
      'status' => $status,
      'message' => $message,
      'data' => $json,
      'token' => $token
    ]

  ];
}


function  typeChat($user)
{
  switch ($user->role_id) {
    case 1:
      $type = "reader_user";
      break;
    case 2:
      $type = "reader_agent";
      break;
    case 3:
      $type = "reader_admin";
      break;
  }

  return $type;
}



function TMDBService($suffixApi, $bodyArray)
{

if (isset($bodyArray['prefixUrl'])  ) {
  $prefixUrl=$bodyArray['prefixUrl'];
  unset($bodyArray['prefixUrl']);
}

  Log::debug('this array = ');
  Log::debug($bodyArray);
  $filteredData = array_filter($bodyArray, function ($value) {
    return $value !== null;
});

  $convertArrayToString = implode('&', $filteredData);
//  dd(config('services.tmdb.api') . $prefixUrl.'?api_key='.config('services.tmdb.token').'&'.$convertArrayToString);
  Log::debug(config('services.tmdb.api') . $prefixUrl.'?api_key='.config('services.tmdb.token').'&'.$convertArrayToString);
  $response = Http::withHeaders([
    'accept' => 'application/json',
  ])->get(
      config('services.tmdb.api') . $prefixUrl.'?api_key='.config('services.tmdb.token').'&'.$convertArrayToString
  );


  return $response;
}

function getMessageByLanguage($toUser, $title, $body)
{
  switch ($toUser->language) {
    case 'value':
      # code...
      break;

    default:
      # code...
      break;
  }
}

function insertToEntertainment(array $data = [],
                                int $categoryFilter = null )
{
    Entertainment::create([
        'user_id' => Filament::auth()->user()->id,
        'tmdb_id' => $data['id'],
        'adult' => $data['adult'],
        'media_type' =>  'tv',
        'media_type_id' => resolveMediaTypeId($data['media_type'] ?? null, $categoryFilter ?? 1),
        'title' => getLocalizedTitle($data),
        'video' => $data['video']??null,
        'collection_id' =>$data['collection_id']  ?? null,
        'overview' => getLocalizedOverview($data) ,
        'genre_ids' => $data['genre_ids'],
        'popularity' => $data['popularity'],
        'vote_count' => $data['vote_count'],
        'poster_path' => $data['poster_path'],
        'release_date' =>getStandardizedReleaseDate($data),
        'vote_average' => $data['vote_average'],
        'backdrop_path' => $data['backdrop_path'],
        'original_title' => $data['original_title'] ?? '',
        'original_language' => $data['original_language'],
    ]);
}

function getLocalizedTitle(array $data): array
{
    $originalLanguage = $data['original_language'] ?? 'en';

    $originalTitle = $data['original_title']
        ?? $data['original_name']
        ?? $data['title']
        ?? $data['name']
        ?? 'عنوان غير معروف';

    $translatedTitle = $data['title']
        ?? $data['name']
        ?? $data['original_title']
        ?? $data['original_name']
        ?? 'عنوان غير معروف';

    // إذا كانت اللغة الأصلية عربية
    if ($originalLanguage === 'ar') {
        return [
            'ar' => $originalTitle,
            'en' => $translatedTitle !== $originalTitle ? $translatedTitle : '',
        ];
    }

    // إذا كانت اللغة الأصلية إنجليزية
    if ($originalLanguage === 'en') {
        return [
            'en' => $originalTitle,
            'ar' => $translatedTitle !== $originalTitle ? $translatedTitle : '',
        ];
    }

    // لغة غير عربية ولا إنجليزية (مثل: hi، fr، ko...)
    // نحاول معرفة إذا الترجمة مكتوبة بالحروف اللاتينية (إنجليزية تقريبًا)
    $isLatin = fn($text) => preg_match('/^[\p{Latin}\d\s\p{P}]+$/u', $text);

    if ($isLatin($translatedTitle)) {
        return [
            'en' => $translatedTitle,
            'ar' => $originalTitle !== $translatedTitle ? $originalTitle : '',
        ];
    }

    // fallback: نضع العنوان الأصلي في en على أي حال
    return [
        'en' => $originalTitle,
        'ar' => '',
    ];
}

function getCombinedLocalizedTitle(array|object $data): string
{
    // إذا كان كائن، حوّله إلى مصفوفة
    if (is_object($data)) {
        $data = (array) $data;
    }

    $originalLanguage = $data['original_language'] ?? 'en';

    $title = $data['title']
        ?? $data['name']
        ?? $data['original_title']
        ?? $data['original_name']
        ?? 'عنوان غير معروف';

    $originalTitle = $data['original_title']
        ?? $data['original_name']
        ?? $title;

    if ($title === $originalTitle) {
        return $title;
    }

    return $originalLanguage === 'ar'
        ? "{$title} ({$originalTitle})"
        : "{$originalTitle} ({$title})";
}

function getLocalizedOverview(array $data): array
{
    $originalLanguage = $data['original_language'] ?? 'en';

    $overview = $data['overview'] ?? null;

    return $originalLanguage === 'ar'
        ? ['ar' => $overview, 'en' =>  $overview]
        : ['en' => $overview, 'ar' =>  $overview];
}
function getStandardizedReleaseDate(array $data): ?string
{
    $rawDate = $data['release_date']
        ?? $data['first_air_date']
        ?? null;
    if (empty($rawDate)) {
        return null;
    }
    try {
        $date = Carbon::parse($rawDate);
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        return null;
    }
}
function resolveMediaTypeId(?string $mediaType = null, ?int $categoryFilter = null): ?int
{
    if (!empty($mediaType)) {
        $mediaType = strtolower($mediaType);

        if (str_contains($mediaType, 'tv')) {
            return 2;
        }

        if (str_contains($mediaType, 'mov')) {
            return 1;
        }

        return null;
    }

    return $categoryFilter;
}


function explodeTitleForm(?string $title): array
{
    [$ar, $en] = explode(' / ', $title . ' / ', 2); // يمنع الخطأ إذا لم يوجد "/"
    return [trim($ar), trim($en)];
}

function getOriginalTitleFromTitleForm(?string $title, ?string $lang): ?string
{
    [$ar, $en] = explodeTitleForm($title);
    return $lang === 'ar' ? $ar : ($lang === 'en' ? $en : null);
}
