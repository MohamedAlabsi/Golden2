<?php
//
//namespace App\Livewire;
//
//use Livewire\Component;
//use App\Models\Year;
//use App\Models\Category;
//use App\Models\Genres;
//use App\Models\VideoType;
//
//class FilterMovies extends Component
//{
//    public $year_id;
//    public $type_id;
//    public $category_id;
//    public $genre_id;
//    public $title;
//
//    public function updatedCategoryId()
//    {
//        $this->genre_id = null;
//    }
//
//    public function applyFilters()
//    {
//        $this->emit('filtersUpdated', [
//            'year_id'     => $this->year_id,
//            'type_id'     => $this->type_id,
//            'category_id' => $this->category_id,
//            'genre_id'    => $this->genre_id,
//            'title'       => $this->title,
//        ]);
//    }
//
//    public function resetFilters()
//    {
//        $this->reset();
//        $this->applyFilters();
//    }
//
//    public function render()
//    {
//        return view('livewire.filter-movies', [
//            'years'      => Year::pluck('years', 'id'),
//            'types'      => VideoType::pluck('name', 'id'),
//            'categories' => Category::pluck('name', 'id'),
//            'genres'     => $this->category_id
//                ? Genres::where('category_id', $this->category_id)->pluck('name', 'tm_id')
//                : collect(),
//        ]);
//    }
//}
