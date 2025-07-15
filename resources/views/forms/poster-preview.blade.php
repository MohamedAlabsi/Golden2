@php
    $url = $getState();

    if (is_array($url)) {
        $url = $url[0] ?? null;
    }

    if (is_string($url)) {
        if (Str::startsWith($url, ['http://', 'https://'])) {
            $previewUrl = $url;
        } elseif (Str::startsWith($url, '/storage/posters')) {
            $previewUrl = url($url);
        } else {
            $previewUrl = 'https://image.tmdb.org/t/p/original' . $url;
        }
    } else {
        $previewUrl = null;
    }
@endphp

@if ($previewUrl)
    <div class="mt-2 w-32 h-48 overflow-hidden rounded shadow border">
        <img src="{{ $previewUrl }}"
             alt="Poster Preview"
             class="w-full h-full object-cover" />
    </div>
@else
    <p class="text-sm text-gray-500">لا توجد صورة حالياً</p>
@endif

