<?php

namespace App\Livewire;

use App\Models\Entertainment;
use App\Services\TmdbService;
use Filament\Notifications\Notification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ListMohammedsLive extends Component
{
    public $query = ''; 
    public $selectedMovies = [];

    public function mount()
    {
        Log::debug("Component mounted");
    }

    public function render()
    {
        Log::debug("Component rendering");

        $tmdbService = app(TmdbService::class);
        $response = $tmdbService->getMovies($this->query, 1);

        $movies = $response['results'];
        $total = $response['total_results'];

        $collection = collect($movies)->map(function ($movie) { 
            $existsInEntertainment = Entertainment::where('tmdb_id', $movie['id'])->exists();
            $movie['check'] = $existsInEntertainment;
            return (object) $movie;
        });

        $lengthAwarePaginatorAll = new LengthAwarePaginator(
            $collection,
            $total,
            4, 
            1,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.list-mohammeds-live', [
            'records' => $lengthAwarePaginatorAll,
            'page' => 1,
        ]);
    }

    public function updatedSelectedMovies($key, $value)
    {
        Log::debug("Selected movies updated: {$key} - {$value}");
    }

    public function updateCheck($movieId, $isChecked)
    {
        Log::debug("Checkbox updated: {$movieId} - {$isChecked}");
        if ($isChecked) {
            $this->selectedMovies[] = $movieId;
        } else {
            $this->selectedMovies = array_diff($this->selectedMovies, [$movieId]);
        }
        $this->skipRender();
    }
}


