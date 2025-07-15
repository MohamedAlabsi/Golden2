<div>
    {{ $this->getTableFiltersForm() }}
    <div class="space-y-6">
{{--        <h1 class="text-2xl font-bold">TMDB Movies</h1>--}}
        <div class="flex gap-6 my-6">  </div>

        <div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));">

            @foreach ($movies as $movie)
                @if (empty($movie->media_type) || $movie->media_type !== 'person')
                    <div class="border rounded-lg p-4 flex flex-col items-center" wire:key="{{$movie->id}}">
                        <input type="checkbox" wire:click="updateChecke({{ json_encode($movie)}},{{ $page }}, $event.target.checked)" {{ $movie->check ? 'checked' : '' }} class="mb-2">

                        <img src="https://image.tmdb.org/t/p/w200{{ $movie->poster_path ?? '' }}"
                             alt="{{ $movie->title ?? $movie->name }}"
                             class="rounded-lg mb-4 w-full movie-image"
                             style="cursor: pointer;">

                        <h8 class="text-center" style="font-size: 16px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; word-wrap: break-word;">{{ $movie->title ?? $movie->name }}</h8>
                        <p class="text-sm text-center">Release Date: {{ $movie->release_date  ?? $movie->first_air_date ?? '' }}</p>
                    </div>
                @endif
            @endforeach

        </div>

        <!-- Pagination Controls -->
        <div class="mt-6">
            {{ $movies->links() }}
        </div>
    </div>




</div>
