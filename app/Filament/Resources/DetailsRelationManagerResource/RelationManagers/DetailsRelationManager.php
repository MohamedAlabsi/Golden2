<?php

namespace App\Filament\Resources\DetailsRelationManagerResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\Entertainment;
use App\Models\EntertainmentExtra;
use App\Models\EntertainmentsDetails;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';
    protected static ?string $title = 'ربط البيانات ';
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tmdb_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tmdb_id')
            ->columns([
                TextColumn::make('tmdb_id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('fetchDetailsFromTMDB')
                    ->label('جلب التفاصيل من TMDB')
                    ->schema(function (Schema $schema, $livewire) {
                        $tmdbId = $livewire->ownerRecord->tmdb_id;
                        $mediaTypeId = $livewire->ownerRecord->media_type_id;

                        if ($mediaTypeId == 1) {
                            $movieData = TMDBService(null, [
                                'prefixUrl' => 'movie/' . $tmdbId,
                                'suffix_request_data' => '?append_to_response=videos,credits,reviews,images',
                            ])->json();

                            if (!empty(data_get($movieData, 'belongs_to_collection.id'))) {
                                $collectionId = $movieData['belongs_to_collection']['id'];
                                $livewire->tmdbCollectionId = $collectionId;

                                $parts = TMDBService(null, [
                                    'prefixUrl' => 'collection/' . $collectionId,
                                ])->json()['parts'] ?? [];

                                $livewire->tmdbCollectionMovies = $parts;

                                return [
                                    CheckboxList::make('selected_collection_movies')
                                        ->label('أفلام السلسلة (Collection)')
                                        ->options(
                                            collect($parts)->mapWithKeys(function ($movie) {
                                                $image = $movie['poster_path']
                                                    ? 'https://image.tmdb.org/t/p/w92' . $movie['poster_path']
                                                    : 'https://via.placeholder.com/92x138?text=No+Image';

                                                $title = $movie['title'] ?? 'بدون عنوان';
                                                $releaseDate = $movie['release_date'] ?? 'بدون تاريخ';

                                                $label = "
    <div style='display: flex; align-items: center; gap: 10px;'>
        <img src='{$image}' width='65' style='border-radius: 4px;'>
        <div>
            <div style='font-weight: bold;'>{$title}</div>
            <small>{$releaseDate}</small>
        </div>
    </div>
";
                                                return [$movie['id'] => new HtmlString($label)];
                                            })->toArray()
                                        )
                                        ->columns(3)
                                        ->required(),
                                ];
                            }
                            return [];
                        }

                        // TV (مسلسل)
                        $tvData = TMDBService(null, [
                            'prefixUrl' => 'tv/' . $tmdbId,
                            'suffix_request_data' => '?append_to_response=videos,credits,reviews,images',
                        ])->json();

                        $livewire->tmdbFetchedDetails = $tvData;

                        return [
                            CheckboxList::make('selected_seasons')
                                ->label('اختر المواسم التي تريد حفظها')
                                ->options(
                                    collect($tvData['seasons'] ?? [])->mapWithKeys(function ($season) {
                                        $image = $season['poster_path']
                                            ? 'https://image.tmdb.org/t/p/w92' . $season['poster_path']
                                            : 'https://via.placeholder.com/92x138?text=No+Image';

                                        $name = $season['name'] ?? 'اسم غير معروف';
                                        $releaseDate = $season['air_date'] ?? 'بدون تاريخ';

                                        $label = "
    <div style='display: flex; align-items: center; gap: 10px; border: 1px solid #ddd; border-radius: 6px; padding: 8px;'>
        <img src='{$image}' width='70' style='border-radius: 4px;'>
        <div>
            <div style='font-weight: bold;'>{$name}</div>
            <small>{$releaseDate}</small>
        </div>
    </div>
";
                                        return [$season['season_number'] => new HtmlString($label)];
                                    })->toArray()
                                )
                                ->columns(3)
                                ->required(),
                        ];
                    })
                    ->action(function ($livewire, array $data) {
                        $mediaTypeId = $livewire->ownerRecord->media_type_id;
                        $entertainmentId = $livewire->ownerRecord->id;

                        if ($mediaTypeId == 1) {
                            $collectionId = $livewire->tmdbCollectionId ?? null;
                            $selectedMovies = collect($livewire->tmdbCollectionMovies ?? [])
                                ->whereIn('id', $data['selected_collection_movies'] ?? [])
                                ->values();

                            foreach ($selectedMovies as $movie) {
                                $movie['collection_id'] = $collectionId;
                                insertToEntertainment($movie, null);
                            }

                            $livewire->ownerRecord->update(['collection_id' => $collectionId]);

                            // نطلب بيانات الفيلم الأساسي فقط لحفظ extras
                            $movieData = TMDBService(null, [
                                'prefixUrl' => 'movie/' . $livewire->ownerRecord->tmdb_id,
                                'suffix_request_data' => '?append_to_response=videos,credits,reviews,images',
                            ])->json();

                            EntertainmentExtra::updateOrCreate(
                                ['entertainment_id' => $entertainmentId],
                                [
                                    'videos' => collect($movieData['videos']['results'] ?? [])->take(5)->values(),
                                    'cast' => collect($movieData['credits']['cast'] ?? [])
                                        ->filter(fn ($p) => !empty($p['character']))
                                        ->take(10)->values(),
                                    'reviews' => collect($movieData['reviews']['results'] ?? [])->take(6)->values(),
                                    'images' => [
                                        'posters' => collect($movieData['images']['posters'] ?? [])->take(4)->values(),
                                        'backdrops' => collect($movieData['images']['backdrops'] ?? [])->take(4)->values(),
                                    ],
                                    'collection' => $movieData['belongs_to_collection']['id'] ?? null,
                                    'seasons' => null,
                                ]
                            );

                            Notification::make()->title('تم حفظ أفلام السلسلة والتفاصيل ✅')->success()->send();
                            return;
                        }

                        // مسلسل
                        $details = $livewire->tmdbFetchedDetails ?? [];
                        $selectedSeasons = collect($details['seasons'] ?? [])
                            ->whereIn('season_number', $data['selected_seasons'] ?? [])
                            ->values()
                            ->toArray();

                        EntertainmentExtra::updateOrCreate(
                            ['entertainment_id' => $entertainmentId],
                            [
                                'videos' => collect($details['videos']['results'] ?? [])->take(5)->values(),
                                'cast' => collect($details['credits']['cast'] ?? [])
                                    ->filter(fn ($p) => !empty($p['character']))
                                    ->take(10)->values(),
                                'reviews' => collect($details['reviews']['results'] ?? [])->take(6)->values(),
                                'images' => [
                                    'posters' => collect($details['images']['posters'] ?? [])->take(4)->values(),
                                    'backdrops' => collect($details['images']['backdrops'] ?? [])->take(4)->values(),
                                ],
                                'collection' => null,
                                'seasons' => $selectedSeasons,
                            ]
                        );

                        Notification::make()->title('تم حفظ المواسم والتفاصيل ✅')->success()->send();
                    }),
            ])

            //            ->headerActions([
//                Action::make('fetchDetailsFromTMDB')
//                    ->label('جلب التفاصيل من TMDB')
//                    ->form(function (Forms\ComponentContainer $form, $livewire) {
//                        $tmdbId = $livewire->ownerRecord->tmdb_id;
//                        $mediaTypeId = $livewire->ownerRecord->media_type_id;
//                        if ($mediaTypeId == 1) {
//                            $response = TMDBService(null, [
//                                'prefixUrl' => 'movie/' . $tmdbId,
//                                'suffix_request_data' => '?append_to_response=videos,credits,reviews,images',
//                            ]);
//
//                                $movieData = $response->json();
//                                if (!empty(data_get($movieData, 'belongs_to_collection.id'))) {
//                                    $collectionId = $movieData['belongs_to_collection']['id'];
//                                    $livewire->tmdbCollectionId = $movieData['belongs_to_collection']['id'];
//                                    $collectionResponse = TMDBService(null, [
//                                        'prefixUrl' => 'collection/' . $collectionId,
//                                    ]);
//
//                                    $collectionData = $collectionResponse->json();
//
//                                    $parts = $collectionData['parts'] ?? [];
//
//                                    // تخزين البيانات داخل الـ Livewire لاستخدامها لاحقًا في ->action()
//                                    $livewire->tmdbCollectionMovies = $parts;
//
//                                    $movieOptions = collect($parts)->mapWithKeys(function ($movie) {
//                                        $image = $movie['poster_path']
//                                            ? 'https://image.tmdb.org/t/p/w92' . $movie['poster_path']
//                                            : 'https://via.placeholder.com/92x138?text=No+Image';
//
//                                        $title = $movie['title'] ?? 'بدون عنوان';
//                                        $releaseDate = $movie['release_date'] ?? 'بدون تاريخ';
//
//                                        $label = "
//                            <div style='display: flex; align-items: center; gap: 10px;'>
//                                <img src='{$image}' width='65' style='border-radius: 4px;'>
//                                <div>
//                                    <div style='font-weight: bold;'>{$title}</div>
//                                    <small>{$releaseDate}</small>
//                                </div>
//                            </div>
//                        ";
//
//                                        return [$movie['id'] => new HtmlString($label)];
//                                    })->toArray();
//
//                                    return [
//                                        Forms\Components\CheckboxList::make('selected_collection_movies')
//                                            ->label('أفلام السلسلة (Collection)')
//                                            ->options($movieOptions)
//                                            ->columns(3)
//                                            ->required(),
//                                    ];
//                                }
//                            return [];
//                        }
//                        $response = TMDBService(null, [
//                            'prefixUrl' => 'tv/' . $tmdbId,
//                            'suffix_request_data' => '?append_to_response=videos,credits,reviews,images',
//                        ]);
//                        $data = $response->json();
//
//                        $livewire->tmdbFetchedDetails = $data;
//
//                        $seasonOptions = collect($data['seasons'] ?? [])->mapWithKeys(function ($season) {
//                            $image = !empty($season['poster_path'])
//                                ? 'https://image.tmdb.org/t/p/w92' . $season['poster_path']
//                                : 'https://via.placeholder.com/92x138?text=No+Image';
//
//                            $title = $season['name'] ?? 'اسم غير معروف';
//                            $releaseDate = $season['air_date'] ?? 'بدون تاريخ';
//
//                            $label = "
//    <div style='display: flex; align-items: center; gap: 10px; border: 1px solid #ddd; border-radius: 6px; padding: 8px;'>
//        <img src='{$image}' width='70' style='border-radius: 4px;'>
//        <div>
//            <div style='font-weight: bold;'>{$title}</div>
//            <small>{$releaseDate}</small>
//        </div>
//    </div>
//";
//
//                            return [
//                                $season['season_number'] => new HtmlString($label),
//                            ];
//                        })->toArray();
//
//
//                        return [
//                            Forms\Components\CheckboxList::make('selected_seasons')
//                                ->label('اختر المواسم التي تريد حفظها')
//                                ->options($seasonOptions)
//                                ->columns(3)
//                                ->required(),
//
//                        ];
//                    })
//
//                    ->action(function ($livewire, array $data) {
//                        $mediaTypeId = $livewire->ownerRecord->media_type_id;
//                        if ($mediaTypeId == 1) {
//                            $selectedMovieIds = $data['selected_collection_movies'] ?? [];
//                            $collectionId = $livewire->tmdbCollectionId ?? null;
//                            $allMovies = $livewire->tmdbCollectionMovies ?? [];
//                            $selectedMovies = collect($allMovies)
//                                ->whereIn('id', $selectedMovieIds)
//                                ->values()
//                                ->all();
//                            foreach ($selectedMovies as $movie) {
//                                $movie['collection_id']= $collectionId;
//                                insertToEntertainment(  $movie,null);
//                                $livewire->ownerRecord->update([
//                                    'collection_id' =>  $collectionId,
//                                ]);
//                            }
//
//                            Notification::make()
//                                ->title('تم حفظ أفلام السلسلة المختارة بنجاح ✅')
//                                ->success()
//                                ->send();
//
//                            return;
//                        }
//                        $details = $livewire->tmdbFetchedDetails ?? [];
//                        $tmdbId = $livewire->ownerRecord->tmdb_id;
//                        $selectedSeasonNumbers = $data['selected_seasons'] ?? [];
//
//                        $selectedSeasons = collect($details['seasons'] ?? [])
//                            ->whereIn('season_number', $selectedSeasonNumbers)
//                            ->values()
//                            ->toArray();
//
//                        $details['seasons'] = $selectedSeasons;
//                        $dataTv= $details['seasons'];
//
//                        EntertainmentExtra::updateOrCreate(
//                            ['entertainment_id' => $livewire->ownerRecord->id],
//                            [
//                                'videos' => collect($movieData['videos']['results'] ?? [])->take(5)->values(),
//                                'cast' =>  collect($movieData['credits']['cast'] ?? [])
//                                    ->filter(fn ($person) => isset($person['character']) && $person['character'] !== '')
//                                    ->take(10)
//                                    ->values(),
//                                'reviews' => collect($movieData['reviews']['results'] ?? [])->take(6)->values(),
//                                'images' => [
//                                    'posters' => collect($movieData['images']['posters'] ?? [])->take(4)->values(),
//                                    'backdrops' => collect($movieData['images']['backdrops'] ?? [])->take(4)->values(),
//                                ],
//                                'collection' => $movieData['belongs_to_collection']['id'] ?? null,
//                                'seasons' =>$dataTv,
//                            ]
//                        );
//                        Notification::make()
//                            ->title('تم حفظ المواسم المختارة بنجاح ✅')
//                            ->success()
//                            ->send();
//                    }),
//            ])

            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
