
<div>

    <form method="GET" action="{{ url()->current() }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            {{-- السنة --}}
            <select name="year_id" class="form-select">
                <option value="">اختر السنة</option>
                @foreach (\App\Models\Year::pluck('years', 'id') as $id => $year)
                    <option value="{{ $id }}" {{ request('year_id') == $id ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            {{-- نوع الفيديو --}}
            <select name="type_id" class="form-select">
                <option value="">اختر اللغة</option>
                @foreach (\App\Models\OriginalLanguage::pluck('name', 'id') as $id => $type)
                    <option value="{{ $id }}" {{ request('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>

            {{-- التصنيف --}}
            <select name="category_id" class="form-select" id="category-select">
                <option value="">اختر التصنيف</option>
                @php
                    $categories = \App\Models\Category::pluck('name', 'id');
                    $defaultCategoryId = \App\Models\Category::where('is_default', true)->value('id');
                    $selectedCategoryId = request('category_id') ?? $defaultCategoryId;
                @endphp

                @foreach ($categories as $id => $name)
                    <option value="{{ $id }}" {{ (string) $selectedCategoryId === (string) $id ? 'selected' : '' }}>
                        {{ is_array($name) ? $name['ar'] ?? reset($name) : $name }}
                    </option>
                @endforeach
            </select>

            {{-- النوع المرتبط بالتصنيف --}}
            <select name="genre_id" class="form-select" id="genre-select"  >
                <option value="">اختر النوع الفرعي</option>
                @php
                    $genres = [];
                    if (request('category_id')) {
                        $genres = \App\Models\Genres::where('category_id', request('category_id'))->pluck('name', 'tm_id');
                    }
                @endphp
                @foreach ($genres as $id => $name)
                    <option value="{{ $id }}" {{ request('genre_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>



            {{-- البحث بالعنوان --}}
            <input type="text" name="title" value="{{ request('title') }}" placeholder="بحث بالعنوان"
                   class="form-input col-span-2"/>

            @php
                $categoryId = request('category_id');
                $sortOptions = [];

                if ($categoryId) {
                    $sortOptions = \App\Models\SortOption::where('category_id', $categoryId)
                        ->pluck('name', 'key');
                }
            @endphp

            <select name="sort_by" id="sort-select" class="form-select">
                <option value="">اختر طريقة الترتيب</option>
                @foreach ($sortOptions as $key => $label)
                    <option value="{{ $key }}" {{ request('sort_by') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            {{-- أزرار التحكم --}}
            <div class="flex gap-6">
                <button
                    class="inline-flex items-center gap-2 text-white font-semibold px-5 py-2 rounded-xl shadow-md transition duration-200"
                    style="background-color: #AA8C13;"
                >
                    <span class="px-4">   </span>
                    🔍 <span class="px-6">بحث</span>
                </button>
                <a href="{{ url()->current() }}"

                   class="inline-flex items-center gap-2 text-white bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2 rounded-xl shadow-md border transition duration-200"
                   style="background-color: #AA8C13;">
                    <span class="px-2">   </span>
                    ↺
                    <span class="px-4">  إعادة تعيين  </span>
                </a>
            </div>
        </div>
    </form>

    <div class="space-y-6">
        <div class="flex gap-6 my-6">  </div>
        <div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));">
            @foreach ($movies as $movie)
                @if (empty($movie->media_type) || $movie->media_type !== 'person')
                    <div class="relative" wire:key="{{ $movie->id }}">
                        <input
                                type="checkbox"
                                id="checkbox-{{ $movie->id }}"
                                wire:click="updateChecke({{ json_encode($movie)}}, {{ $page }}, $event.target.checked)"
                                {{ $movie->check ? 'checked' : '' }}
                                class="absolute -top-2 -right-2 w-4 h-4 cursor-pointer bg-white rounded border-gray-300 shadow z-20"
                        >

                        <div class="border rounded-lg py-4 flex flex-col items-center">

                        <label for="checkbox-{{ $movie->id }}"
                                   class="relative w-full cursor-pointer rounded-lg overflow-hidden">
                                <img src="{{ $movie->poster_path ? 'https://image.tmdb.org/t/p/w200' . $movie->poster_path : 'https://dummyimage.com/200x300/cccccc/000000&text=No+Image' }}"
                                     alt="{{ $movie->title ?? $movie->name }}"
                                     class="rounded-lg w-full movie-image transition duration-200">
                            </label>
                            <h3 class="text-center mt-2"
                                style="font-size: 14px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; word-wrap: break-word;"
                                title="{{ getCombinedLocalizedTitle($movie) }}">

                                {{ getCombinedLocalizedTitle($movie) }}
                            </h3>
                            <p class="text-sm text-center">
                                {{ $movie->release_date ?? $movie->first_air_date ?? '' }}
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- الترقيم --}}
        <div class="mt-6">
            {{ $movies->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>


<script>
    // تحديث خيارات الترتيب
    function updateSortOptions(categoryId, setDefault = false) {
        fetch(`/api/sort-options?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const sortSelect = document.getElementById('sort-select');
                if (!sortSelect) return;

                // تفريغ القائمة القديمة
                sortSelect.innerHTML = '<option value="">اختر طريقة الترتيب</option>';

                const options = data.options || {};
                const defaultKey = data.default || null;

                let defaultSet = false;

                for (const [key, label] of Object.entries(options)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.text = label;

                    // ✅ تعيين الافتراضي إذا طُلب
                    if (setDefault && !defaultSet && key === defaultKey) {
                        option.selected = true;
                        defaultSet = true;
                    }

                    sortSelect.appendChild(option);
                }

                // ✅ في حال لم يتم التعيين في القائمة لأي سبب
                if (setDefault && !sortSelect.value && defaultKey) {
                    sortSelect.value = defaultKey;
                }
            });
    }

    // عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const sortBy = urlParams.get('sort_by');

        // ✅ قراءة category_id من القائمة المختارة نفسها
        const categorySelect = document.getElementById('category-select');
        const categoryId = categorySelect ? categorySelect.value : null;

        if (categoryId && !sortBy) {
            updateSortOptions(categoryId, true);
        }
    });
    // عند تغيير التصنيف
    document.getElementById('category-select')?.addEventListener('change', function () {
        const categoryId = this.value;

        if (!categoryId) return;

        // تحديث الترتيب والأنواع الفرعية
        updateSortOptions(categoryId, true);

        fetch(`/api/genres?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const genreSelect = document.getElementById('genre-select');
                if (!genreSelect) return;

                genreSelect.innerHTML = '<option value="">اختر النوع الفرعي</option>';

                for (const [id, name] of Object.entries(data)) {
                    const option = document.createElement('option');
                    option.value = id;
                    option.text = name;
                    genreSelect.appendChild(option);
                }
            });
    });
</script>




