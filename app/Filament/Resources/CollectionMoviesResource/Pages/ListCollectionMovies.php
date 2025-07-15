<?php

namespace App\Filament\Resources\CollectionMoviesResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CollectionMoviesResource;
use App\Models\Collection;
use App\Models\CollectionEntertainment;
use App\Models\Entertainment;
use App\Models\Year;
use App\Services\TmdbService;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Renderless;
use Livewire\WithPagination;

class ListCollectionMovies extends ListRecords
{
    protected static string $resource = CollectionMoviesResource::class;
    protected string $view = 'livewire.collection-movie-list';
    use WithPagination;
    protected $page = 1;
    public ?array $data = [];
    public $isD = true;
    public $moviesInThisPage;
    protected   $lengthAwarePaginatorAll;
    public   $lengthAwarePaginatorAllpublic;

    public $moviesAll ;
    public $moviesSelected ;
    public $movieId ;
    protected   $listMovies;
    public $modalImage;

    protected $collectionFilter;
    protected $yearFilter;
    protected $typeFilter;
    protected $searchFilter;

    protected $genresFilter;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableColumns(): array
    {
        $columns = [
            TextColumn::make('name')->label(('jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj')),
        ];
        return $columns;
    }

    protected function getTableFilters(): array
    {

        return [
            SelectFilter::make("suppdddddddddddddddddddddlier_id")
                ->label(('lang.suppldddddddddddddddddddddddddddier'))
                ->query(function (Builder $q, $data) {
                    return $q;
                })->options(Year::get()->pluck('years', 'id')),

        ];
    }



    public static function getPluralLabel(): ?string
    {
        return  ' purchase_invoice_report';
    }


    protected function getTableFiltersLayout(): ?string
    {
        return $this->getResourceTable()->getFiltersLayout();
    }
    // protected function getFormSchema(): array
    // {
    //     return [

    //         Select::make('country_id')
    //         ->options(Category::all()->pluck('name', 'id'))
    //     ];
    // }
    public function updatingSearch()
    {
        // $this->resetPage();
    }


    public function resetPage($pageName = 'page'): void
    {
    }

    public function updatingPage($page)
    {
    }

    public function updatedPage($page)
    {
        $this->page = $page;
        // Runs after the page is updated for this component...
    }


    // public function mount(): void
    // {
    //     parent::mount();
    //     Log::debug("mount mount mount");

    // }


    #[Renderless]
    protected function getViewData(): array
    {
        $this->collectionFilter=$this->getTableFilterState("collection_id")["value"];


        $this->page = request()->get('page', 1);
        $this->fetchMovies($this->page);
//dd($this->lengthAwarePaginatorAll);
        Log::debug('LengthAwarePaginatorLengthAwarePaginatorLengthAwarePaginator3');
        return [
            'movies' =>   $this->lengthAwarePaginatorAll,
            'page' =>  $this->page,
        ];

    }
    public $query = '';



    public function fetchMovies($page = 1)
    {


Log::debug('ssssssssssssssssssssssssss'. $this->collectionFilter);
        $collectionEntertainment = CollectionEntertainment::where('collection_id', $this->collectionFilter)
            ->pluck('entertainment_id')
            ->toArray();

        $existingIds = Entertainment::whereIn('id', $collectionEntertainment)
            ->pluck('id')
            ->toArray();

        $collection = Entertainment::whereIn('id', $collectionEntertainment)
            ->get()
            ->map(function ($item) use ($existingIds) {
                $item->check = in_array($item->tmdb_id, $existingIds);
                return $item;
            });

//dd($collectionEntertainment);
// 4. Pagination
        $page = request()->get('page', 1);

        $this->lengthAwarePaginatorAll = new LengthAwarePaginator(
            $collection,
            0,
            4,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );



        return   $this->lengthAwarePaginatorAll;
        // }
    }


    public function updateChecke($movie, $page,$isChecked)
    {



        if ($isChecked) {

            // Add to entertainment table if checked and not already present
            Entertainment::create([
                'tmdb_id' => $movie['id'],
                'adult' => $movie['adult'],
                'media_type' => $movie['media_type']??'movie',
                'title' => $movie['title']?? $movie['name'],
                'video' => $movie['video']??null,
                'overview' => $movie['overview'],
                'genre_ids' => $movie['genre_ids'],
                'popularity' => $movie['popularity'],
                'vote_count' => $movie['vote_count'],
                'poster_path' => $movie['poster_path'],
                'release_date' => $movie['release_date']
                    ?? $movie['first_air_date']
                        ?? null,
                'vote_average' => $movie['vote_average'],
                'backdrop_path' => $movie['backdrop_path'],
                'original_title' => $movie['original_title'] ?? '',
                'original_language' => $movie['original_language'],
            ]);

            // $movie->save();
            // Optionally provide feedback
            Notification::make()
                ->title('Movie Added')
                ->body('Movie "' . ($movie['title']  ?? $movie['name'] ) . '" تم اضافته بنجاج.')
                ->duration(500)
                ->success()
                ->send();

        } elseif (!$isChecked ) {
            // Remove from entertainment table if unchecked and present
            Entertainment::where('tmdb_id', $movie['id'])->delete();
            // Optionally provide feedback

            Notification::make()
                ->title('Movie Removed')
                ->body('Movie "' .  ($movie['title']  ?? $movie['name'] )  . '" تم حذفه بنجاح.')
                ->duration(500)
                ->warning()
                ->send();
        }

        $this->skipRender();


    }


}
