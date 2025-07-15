<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CollectionMoviesResource\Pages\ListCollectionMovies;
use App\Filament\Resources\CollectionMoviesResource\Pages;
use App\Filament\Resources\CollectionMoviesResource\RelationManagers;
use App\Models\Category;
use App\Models\Collection;
use App\Models\CollectionMovies;
use App\Models\Movies2;
use App\Models\OriginalLanguage;
use App\Models\Year;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollectionMoviesResource extends Resource
{
//    protected static ?string $model = CollectionMovies::class;
    protected static ?string $model = Movies2::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return __('lang.test');
    }
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')->label('titletitdddddle')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextInput::make('search')
                // ->suffixIcon('x-heroicon-o-truck')
                TextColumn::make('title')->label('titletitle'),
            ])
            ->filters([

                SelectFilter::make('collection_id')
                    ->label('Collection')
                    ->options(
                        Collection::all()
                            ->mapWithKeys(function ($item) {
                                $name = data_get($item->name, 'ar');
                                return $name ? [$item->id => $name] : [];
                            })
                            ->toArray()
                    )
                    ->default(1) // ← هذا هو المفتاح: يحدد القيمة الافتراضية
                    ->placeholder(null) // ← يخفي خيار "الكل"
                    ->query(function (Builder $query, $value) {
                        return $query->where('collection_id', $value ?? 1);
                    })

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


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
             'index' => ListCollectionMovies::route('/'),
//            'create' => Pages\CreateCollectionMovies::route('/create'),
//            'edit' => Pages\EditCollectionMovies::route('/{record}/edit'),
        ];
    }
}
