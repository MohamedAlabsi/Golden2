<?php

namespace App\Filament\Resources\SimilarCollectionRelationManagerResource\RelationManagers;


use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use App\Models\Entertainment;
use App\Models\Slider;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SimilarCollectionRelationManager extends RelationManager
{
    // نستعمل علاقة موجودة فعلًا، فقط لتجاوز التحقق
    protected static string $relationship = 'similarCollection';

    public static function getLabel(): ?string
    {
        return 'مجموعة';
    }
    protected static ?string $title = 'مجموعة';

    public static function getPluralLabel(): ?string
    {
        return 'مجموعة';
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('media_type')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('العنوان')
                    ->formatStateUsing(fn ($record) => $record->title ?? '—')
                    ->searchable()
                    ->extraAttributes(fn ($record) => [
                        'title' => $record->title ?? '',
                        'style' => 'max-width: 150px; overflow: hidden; white-space: normal; word-wrap: break-word;',
                    ]),


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
                    ->date()
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
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->recordActions([
                DeleteAction::make(), // ✅ زر الحذف لكل صف
            ]);
    }
}
