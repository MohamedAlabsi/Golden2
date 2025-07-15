<?php

namespace App\Filament\Resources;
//use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
use App\Models\Category;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\EntertainmentResource\Pages\ListEntertainments;
use App\Filament\Resources\EntertainmentResource\Pages\CreateEntertainment;
use App\Filament\Resources\EntertainmentResource\Pages\EditEntertainment;
use App\Filament\Resources\EntertainmentResource\Pages\ViewEntertainments;
use App\Filament\Resources\DetailsRelationManagerResource\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\EntertainmentResource\Pages;
use App\Filament\Resources\SimilarCollectionRelationManagerResource\RelationManagers\SimilarCollectionRelationManager;
use App\Models\OriginalLanguage;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use App\Models\Entertainment;
use App\Models\Genres;
use App\Models\Slider;
use App\Models\Years;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
class EntertainmentResource extends Resource
{
    protected static ?string $model = Entertainment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
//    use Translatable;
    protected static ?int $navigationSort = 2;
    public static function getTranslatableLocales(): array
{
    return ['en', 'ar'];
}
    public static function getLabel(): ?string
    {
        return 'افلامي ومسلسلاتي';
    }


    public static function getPluralLabel(): ?string
    {
        return 'افلامي ومسلسلاتي';
    }


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                Grid::make(3)->schema([
                    TextInput::make('tmdb_id')
                        ->numeric()->disabled(),
                    Select::make('user_id')
                        ->label('المستخدم')
                        ->options([
                            Filament::auth()->user()->id => Filament::auth()->user()->name,
                        ])
                        ->default(Filament::auth()->user()->id)
                        ->disabled()
                        ->dehydrated(),
                    Toggle::make('adult')->label('للبالغين ')->default(false),
                ]),
                ]) ->columnSpanFull(),
                Section::make()->schema([
                Grid::make(5)->schema([
                    Select::make('media_type_id')
                        ->label('نوع الوسيط')
                        ->options(
                            Category::query()
                                ->orderBy('name') // ترتيب أبجدي
                                ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function (callable $set) {
                            $set('genre_ids', []);
                        }),

                    Select::make('genre_ids')
                        ->label('التصنيفات')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->options(function (callable $get) {
                            $mediaTypeId = $get('media_type_id');

                            return Genres::query()
                                ->when($mediaTypeId, fn($query) => $query->where('category_id', $mediaTypeId))
                                ->orderBy('name')
                                ->pluck('name', 'tm_id');
                        })
                        ->required()
                        ->dehydrateStateUsing(fn($state) => array_map('intval', $state))
                        ->columnSpan(2),

                    TextInput::make('popularity')
                        ->numeric()
                        ->default(130.0)->label('الشعبية'),

                    TextInput::make('vote_count')
                        ->numeric()
                        ->default(600)->label('عدد الأصوات'),
                    TextInput::make('vote_average')
                        ->numeric()
                        ->default(6.8)->label('متوسط الأصوات'),
                ]),
                ]) ->columnSpanFull(),



                Section::make()->schema([

                Grid::make(3)->schema([
                    Select::make('original_language')
                        ->label('اللغة الأصلية')
                        ->options(fn () => OriginalLanguage::pluck('name', 'value')->toArray())
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive()
                        ->live(),
                    TextInput::make('original_title')
                        ->label(fn ($get) =>
                        $get('original_language') === 'ar'
                            ? 'العنوان الأصلي (عربي)'
                            : 'العنوان الأصلي (إنجليزي)'
                        )
                        ->maxLength(191)
                        ->reactive(),

                    TextInput::make('title')
                        ->label(fn ($get) =>
                        $get('original_language') === 'ar'
                            ? 'العنوان (إنجليزي)'
                            : 'العنوان (عربي)'
                        )
                        ->maxLength(191)
                        ->reactive(),
                ]),
                ]) ->columnSpanFull(),
                Textarea::make('overview_ar')
                    ->label(fn (Get $get) =>
                    $get('original_language') === 'ar'
                        ? 'الوصف (عربي - أصلي)'
                        : 'الوصف (عربي - ترجمة)'
                    )
                    ->maxLength(1000)
                    ->reactive(),

                Textarea::make('overview_en')
                    ->label(fn (Get $get) =>
                    $get('original_language') === 'ar'
                        ? 'الوصف (إنجليزي - ترجمة)'
                        : 'الوصف (إنجليزي - أصلي)'
                    )
                    ->maxLength(1000)
                    ->reactive(),





//                 Forms\Components\TextInput::make('genre_ids'),

                TextInput::make('poster_path')
                    ->label('رابط الصورة')
                    ->maxLength(191)
                    ->disabled()
                    ->hidden(),


                Section::make([
                    Group::make([
                        TextInput::make('poster_url')
                            ->label('رابط البوستر (اختياري)')
                            ->placeholder('https://image.tmdb.org/t/p/w500/xyz.jpg')
                            ->reactive()
                            ->afterStateUpdated(fn (Set $set, $state) => $set('poster_path', $state)),


                        FileUpload::make('poster_upload')
                            ->label('أو رفع صورة من جهازك')
                            ->image()
                            ->imagePreviewHeight('200')
                            ->downloadable()
                            ->openable()
                            ->preserveFilenames(false)
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (! $state instanceof TemporaryUploadedFile) {
                                    return;
                                }
                                $extension = $state->getClientOriginalExtension();
                                $newName = Str::uuid() . '.' . $extension;
                                $newPath = $state->storeAs('public/posters', $newName);
                                $publicUrl = Storage::url(str_replace('public/', '', $newPath));
                                $set('poster_path', $publicUrl);
                            }),

                        View::make('forms.poster-preview')
//                            ->label('معاينة البوستر')
                            ->statePath('poster_path')
                            ->visible(fn (Get $get) => filled($get('poster_path')))
                    ])->columns(3),
                ])
                    ->columnSpan('full'),



                DatePicker::make('release_date')
                    ->label('تاريخ الإصدار')
                    ->default(Carbon::today()),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('category.name') // 👈 نستخدم العلاقة للوصول إلى الاسم
                ->label('نوع الوسيط')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label('نوع الوسيط')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('title_text')
                    ->label('العنوان')
                    ->searchable(
                        query: fn ($query, $search) =>
                        $query->where(function ($q) use ($search) {
                            $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.ar'))) LIKE ?", ['%' . strtolower($search) . '%'])
                                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.en'))) LIKE ?", ['%' . strtolower($search) . '%']);
                        })
                    )
                    ->wrap() // للسماح بلف النص في العمود
                    ->tooltip(function ($record) {
                        $translations = $record->getTranslations('title');
                        return implode(' / ', array_filter($translations));
                    }) ,


                TextColumn::make('overview')
                    ->label('الوصف')
                    ->formatStateUsing(fn ($record) => $record->title ?? '—')
                    ->searchable()
                    ->extraAttributes(fn ($record) => [
                        'style' => 'white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;',
                        'title' => $record->overview,
                    ])
            ->formatStateUsing(function ($state) {
                return Str::limit($state, 50);
            }),

                TextColumn::make('overview')->wrap()->limit(50)
                    ->searchable()
                    ->extraAttributes(function ($record) {
                        return [
                            'style' => 'white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;',
                            'title' => $record->overview,
                        ];
                    })
                    ->formatStateUsing(function ($state) {
                        return Str::limit($state, 50);
                    }),

                TextColumn::make('genre_names')
                           ->label('Genres')
                           ->formatStateUsing(fn ($state, $record) => implode(', ', $record->genre_names))
                           ->extraAttributes([
                               'style' => 'max-width: 200px; white-space: normal; word-wrap: break-word;',
                           ]),

                ImageColumn::make('poster_path')
                    ->label('Image')
                    ->size(80)
                    ->getStateUsing(function ($record) {
                        $path = $record->poster_path;
                        if (Str::startsWith($path, ['http://', 'https://'])) {
                            return $path;
                        }
                        if (Str::startsWith($path, '/storage/posters')) {
                            return url($path);
                        }
                        return 'https://image.tmdb.org/t/p/original' . $path;
                    })
                    ->extraAttributes(['class' => 'custom-image']),
                TextColumn::make('release_date')
                    ->label('تاريخ الإصدار')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('Y-m-d'))
                    ->sortable(),

                CheckboxColumn::make('is_top_movie')
                    ->label('فيلم مميز')
                    ->sortable() ,

                CheckboxColumn::make('is_top_series')
                    ->label('مسلسل مميز')
                    ->sortable(),


                CheckboxColumn::make('is_slider')
                    ->label('سلايدر')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state) {
                             Slider::create([
                                'entertainment_id' => $record->id,
                                'user_id' => auth()->id(),
                                'active' => true,
                            ]);
                        } else {
                            Slider::where('entertainment_id', $record->id)
                                ->where('user_id', auth()->id())
                                ->delete();
                        }
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('media_type')
                    ->schema([
                        Select::make('media_type')
                            ->label('نوع المحتوى')
                            ->native(false) // ✅ يمنع ظهور "اختر"
                            ->required()    // ✅ يفرض اختيار
                            ->default('all') // ✅ يبدأ بـ "الكل"
                            ->options([
                                'all' => 'الكل',
                                'tv' => 'TV',
                                'not_tv' => 'Movies',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(($data['media_type'] ?? 'all') === 'tv', fn ($q) =>
                            $q->where('media_type', 'tv')
                            )
                            ->when(($data['media_type'] ?? 'all') === 'not_tv', fn ($q) =>
                            $q->where('media_type', '!=', 'tv')
                            );
                    }),

                // 🌟 فلتر الأعمال المميزة (top only)
                Filter::make('is_top')
                    ->schema([
                        Select::make('is_top')
                            ->label('محتوى مميز')
                            ->native(false) // ✅ يُخفي "اختر"
                            ->required()    // ✅ يجبر على الاختيار
                            ->default('all') // ✅ يبدأ بـ "الكل"
                            ->options([
                                'all' => 'الكل',
                                'top_movie' => 'Top Movie',
                                'top_series' => 'Top Series',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(($data['is_top'] ?? 'all') === 'top_movie', fn ($q) =>
                            $q->where('is_top_movie', true)
                            )
                            ->when(($data['is_top'] ?? 'all') === 'top_series', fn ($q) =>
                            $q->where('is_top_series', true)
                            );
                    }),
                Filter::make('is_slider')
                    ->schema([
                        Select::make('is_slider')
                            ->label('السلايدر')
                            ->native(false) // ✅ هذا يُفعّل القائمة المخصصة ويمنع "اختر"
                            ->default('all')
                            ->required()
                            ->options([
                                'all' => 'الكل',
                                '1' => 'في السلايدر',
                                '0' => 'ليس في السلايدر',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(($data['is_slider'] ?? 'all') !== 'all', function ($q) use ($data) {
                            return $q->where('is_slider', $data['is_slider']);
                        });
                    }),


            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderByDesc('id'); // ترتيب تنازلي حسب ID
    }
    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
            SimilarCollectionRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => ListEntertainments::route('/'),
            'create' => CreateEntertainment::route('/create'),
            'edit' => EditEntertainment::route('/{record}/edit'),
            'view' => ViewEntertainments::route('/{record}'),
        ];
    }
}
