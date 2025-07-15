<?php


namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\TmdbService;
use Illuminate\Pagination\LengthAwarePaginator;

class TmdbMovieList extends Component
{
    use WithPagination;

    public $query = 'Ince'; // استعلام الفيلم الافتراضي

    public function render()
    {
        $movies = $this->fetchMovies(); 
        return view('livewire.tmdb-movie-list', compact('movies'));
    }

    public function fetchMovies()
    {
         
        $page = $this->page??1 ; // الحصول على الصفحة الحالية من Livewire
        $tmdbService = app(TmdbService::class); // الحصول على خدمة TMDB
        $response = $tmdbService->getMovies($this->query, $page); // جلب الأفلام من TMDB

        $movies = $response['results'];
        $total = $response['total_results']; // إجمالي النتائج

        // تحويل الأفلام إلى كائنات
        $collection = collect($movies)->map(function ($movie) {
            return (object) $movie;
        });

        // إنشاء LengthAwarePaginator باستخدام المجموعة
        return new LengthAwarePaginator(
            $collection,
            $total,
            30, // عدد العناصر لكل صفحة
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}

