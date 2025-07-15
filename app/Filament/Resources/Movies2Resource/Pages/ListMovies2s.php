<?php

namespace App\Filament\Resources\Movies2Resource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Movies2Resource;
use App\Models\Category;
use App\Models\Entertainment;
use App\Models\OriginalLanguage;
use App\Models\SelectTemporary;
use App\Models\User;
use App\Models\Year;
use App\Models\Years;
use App\Services\TmdbService;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Filament\Tables\Table;
use Livewire\Attributes\Renderless;
use Filament\Facades\Filament;
use Spatie\Translatable\HasTranslations;
class ListMovies2s extends ListRecords
{
    // use ListRecords\Concerns\Translatable;
    protected static string $resource = Movies2Resource::class;
    protected string $view = 'livewire.tmdb-movie-list';
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

    public $categoryFilter;
    public $yearFilter;
    public $typeFilter;
    public $searchFilter;

    public $genresFilter;
    public $sortBy;

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
            // Select::make('country_id') ->options(Category::all()->pluck('name', 'id')) ,
            //    Select::make('country_id') ->options(Years::all()->pluck('name', 'id')) ,
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
//        $this->categoryFilter=$this->getTableFilterState("category")["value"]??null;
//        $this->yearFilter=$this->getTableFilterState("advanced")['year']["value"]??null;
//        $this->genresFilter=$this->getTableFilterState("genre")["value"]??null;
//        $this->typeFilter=$this->getTableFilterState("type")["value"]??null;
//        $this->searchFilter=$this->getTableFilterState("title")["title"]??null;

        $this->categoryFilter = request()->get('category_id')??null;
        $id = request()->get('year_id');
        $this->yearFilter = $id ? Year::find($id)?->years: null;
        $this->genresFilter = request()->get('genre_id')??null;
        $this->sortBy = request()->get('sort_by')??'popularity.desc';
        $typeId = request()->get('type_id');
        $this->typeFilter = $typeId ? OriginalLanguage::find($typeId)?->value : null;
        $this->searchFilter = request()->get('title')??null;
        $this->page = request()->get('page', 1);
        $this->fetchMovies($this->page);
        return [
            'movies' =>   $this->lengthAwarePaginatorAll,
            'page' =>  $this->page,
        ];

    }
    public $query = '';



    public function fetchMovies($page = 1)
    {
        ini_set('memory_limit', '512M');


        $tmdbService = app(TmdbService::class);

//        $response = $tmdbService->getDataFilter($this->query, $page,$this->categoryFilter ,$this->yearFilter , $this->typeFilter,$this->searchFilter,$this->genresFilter,$this->sortBy);
        $perPage = 20; // هذا هو العدد الذي ترجع فيه TMDB النتائج في كل صفحة

        $response = $tmdbService->getDataFilter(
            $this->query,
            $page,
            $this->categoryFilter,
            $this->yearFilter,
            $this->typeFilter,
            $this->searchFilter,
            $this->genresFilter,
            $this->sortBy
        );
        logger()->info('🚨 بعد getData: ' . memory_get_peak_usage(true));
        $movies = $response['results'];
        $total = $response['total_results'];



        $tmdbIds = collect($movies)->pluck('id')->toArray();

        $existingIds = Entertainment::whereIn('tmdb_id', $tmdbIds)->pluck('tmdb_id')->toArray();
        logger()->info('🚨 بعد whereIn: ' . memory_get_peak_usage(true));
        $collection = collect($movies)->map(function ($movie) use ($existingIds) {
            $movie['check'] = in_array($movie['id'], $existingIds);
            return (object) $movie;
        });
        $page = request()->get('page', 1);
        logger()->info('🚨 بعد map: ' . memory_get_peak_usage(true));
        $this->lengthAwarePaginatorAll = new LengthAwarePaginator(
            $collection,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        $used = memory_get_usage(true);

        $peak = memory_get_peak_usage(true);

        logger()->info('📦 Memory used: ' . number_format($used / 1024 / 1024, 2) . ' MB');
        logger()->info('🚀 Peak memory usage: ' . number_format($peak / 1024 / 1024, 2) . ' MB');

        return   $this->lengthAwarePaginatorAll;
    }


    public function updateChecke($movie, $page,$isChecked)
    {


        if ($isChecked) {
            insertToEntertainment( $movie,$this->categoryFilter);
//            Entertainment::create([
//                'user_id' => Filament::auth()->user()->id,
//                'tmdb_id' => $movie['id'],
//                'adult' => $movie['adult'],
//                'media_type' =>  $this->searchFilter!=null  ?  $movie['media_type'] : ($this->categoryFilter==2?'tv' : 'movie'),
//                'title' => in_array($movie['original_language'] ?? null, ['ko', 'zh'])
//                    ? ($movie['title'] ?? $movie['name'])
//                    : ($movie['original_title'] ?? ($movie['title'] ?? $movie['name'])),
//                'video' => $movie['video']??null,
//                'overview' => $movie['overview'],
//                'genre_ids' => $movie['genre_ids'],
//                'popularity' => $movie['popularity'],
//                'vote_count' => $movie['vote_count'],
//                'poster_path' => $movie['poster_path'],
//                'release_date' => $movie['release_date']
//                    ?? $movie['first_air_date']
//                        ?? null,
//                'vote_average' => $movie['vote_average'],
//                'backdrop_path' => $movie['backdrop_path'],
//                'original_title' => $movie['original_title'] ?? '',
//                'original_language' => $movie['original_language'],
//            ]);

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


    // public function openAlert($imageSrc)
    // {
    //     $this->modalImage = "https://image.tmdb.org/t/p/w500" . $imageSrc;

    //     $this->dispatch('postAdded',  $this->modalImage );
    // }



}
