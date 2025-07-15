{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <!-- تضمين مكتبة JavaScript مثل jQuery لاستخدامها في AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="grid gap-6" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
        @foreach ($movies as $movie)
            <div class="border rounded-lg p-4 flex flex-col items-center">
                <input type="checkbox"
                       id="checkbox-{{ $movie->id }}"
                       onchange="handleCheckboxChange({{ $movie->id }}, this.checked)"
                       {{ $movie->check ? 'checked' : '' }} class="mb-2">
                <a href="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" data-lightbox="movie-{{ $movie->id }}">
                    <img src="https://image.tmdb.org/t/p/w200{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="rounded-lg mb-4 w-full">
                </a>
                <h8 class="text-center" style="font-size: 20px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $movie->title }}</h8>
                <p class="text-sm text-center">Release Date: {{ $movie->release_date }}</p>
            </div>
        @endforeach
    </div>

    <script>
        function handleCheckboxChange(movieId, isChecked) {
            $.ajax({
                url: '/update-check',  // تأكد من أن هذا المسار موجود في ملف routes/web.php
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: movieId,
                    check: isChecked
                },
                success: function(response) {
                    console.log('Update successful', response);
                },
                error: function(error) {
                    console.log('Update failed', error);
                }
            });
        }
    </script>
</body>
</html> --}}

<div>
    @foreach ($records as $record)
        <div class="border rounded-lg p-4 flex flex-col items-center" wire:key="{{ $record->id }}">
            <input type="checkbox" 
                   wire:click="updateCheck({{ $record->id }}, $event.target.checked)"
                   {{ in_array($record->id, $selectedMovies) ? 'checked' : '' }} class="mb-2">
            <a href="https://image.tmdb.org/t/p/w500{{ $record->poster_path }}" data-lightbox="movie-{{ $record->id }}">
                <img src="https://image.tmdb.org/t/p/w200{{ $record->poster_path }}" alt="{{ $record->title }}" class="rounded-lg mb-4 w-full">
            </a>
            <h8 class="text-center" style="font-size: 20px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $record->title }}</h8>
            <p class="text-sm text-center">Release Date: {{ $record->release_date }}</p>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>


