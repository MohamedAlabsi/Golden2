<?php

namespace App\Filament\Resources;

//use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Movies2Resource\Pages\ListMovies2s;
use App\Filament\Resources\Movies2Resource\Pages;
use App\Filament\Resources\Movies2Resource\RelationManagers;
use App\Filament\Resources\PostResource\Widgets\PostsStats;
use App\Models\Category;
use App\Models\Genres;
use App\Models\Movies2;
use App\Models\OriginalLanguage;
use App\Models\VidioType;
use App\Models\Year;
use App\Models\Years;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;
use Filament\Forms\Components\Grid;
use Spatie\Translatable\HasTranslations;
class Movies2Resource extends Resource
{
//    use Translatable;
    protected static ?string $model = Movies2::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getLabel(): ?string
    {
        return 'تصفح الافلام والمسلسلات';
    }


    public static function getPluralLabel(): ?string
    {
        return 'تصفح الافلام والمسلسلات';
    }
    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')->label('titletitdddddle')
                ->required(),
            ]);
    }
    public static function getWidgets(): array
    {
        return [
            PostsStats::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('عنوان الفيديو'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
    public static function getPages(): array
    {
        return [
            'index' => ListMovies2s::route('/'),
            // 'edit' => Pages\EditStockReport::route('/{record}/edit'),
        ];
    }


    // public static function getPages(): array
    // {
    //     return [
    //         'index' => Pages\ListMovies2s::route('/'),
    //         'create' => Pages\CreateMovies2::route('/create'),
    //         'edit' => Pages\EditMovies2::route('/{record}/edit'),
    //     ];
    // }
}
