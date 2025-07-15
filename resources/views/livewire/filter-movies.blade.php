<div class="space-y-4 mb-4">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <select wire:model="year_id" class="form-select">
            <option value="">اختر السنة</option>
            @foreach($years as $id => $year)
                <option value="{{ $id }}">{{ $year }}</option>
            @endforeach
        </select>

        <select wire:model="type_id" class="form-select">
            <option value="">اختر النوع</option>
            @foreach($types as $id => $type)
                <option value="{{ $id }}">{{ $type }}</option>
            @endforeach
        </select>

        <select wire:model="category_id" class="form-select">
            <option value="">اختر التصنيف</option>
            @foreach($categories as $id => $cat)
                <option value="{{ $id }}">{{ $cat }}</option>
            @endforeach
        </select>

        <select wire:model="genre_id" class="form-select">
            <option value="">اختر النوع</option>
            @foreach($genres as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <input type="text" wire:model="title" class="form-input" placeholder="بحث بالعنوان">
    </div>

    <div class="flex gap-2">
        <button wire:click="applyFilters" class="btn btn-primary">🔍 بحث</button>
        <button wire:click="resetFilters" class="btn btn-secondary">إعادة تعيين</button>
    </div>
</div>
