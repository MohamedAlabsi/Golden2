<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\GenreResource\Pages\ListGenres;
use App\Filament\Resources\GenreResource\Pages\CreateGenre;
use App\Filament\Resources\GenreResource\Pages\EditGenre;
use App\Filament\Resources\GenreResource\Pages;
use App\Filament\Resources\GenreResource\RelationManagers;
use App\Models\Genre;
use App\Models\Genres;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GenreResource extends Resource
{
    protected static ?string $model = Genres::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getLabel(): ?string
    {
        return 'التصنيفات';
    }
    protected static ?int $navigationSort = 6;

    public static function getPluralLabel(): ?string
    {
        return 'التصنيفات';
    }
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('category_id')
                ->label('التصنيف الرئيسي')
                ->relationship(
                    name: 'category',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->orderBy('id', 'asc')
                )
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('name.ar')
                ->label('الاسم (عربي)')
                ->required(),

            TextInput::make('name.en')
                ->label('الاسم (إنجليزي)')
                ->required(),

            Toggle::make('active')
                ->label('نشط')
                ->default(true),
            TextInput::make('tm_id')
                ->label('رقمه في TMDB')
                ->numeric()
                ->default(function () {
                    do {
                        $randomId = rand(64000, 65000);
                    } while (Genres::where('tm_id', $randomId)->exists());

                    return $randomId;
                })
                ->readOnly()
                ->required(),
            TextInput::make('order')
                ->label('الترتيب')
                ->numeric()
                ->default(function () {
                    return Genres::max('order') + 1;
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
            return $table->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('tm_id')->sortable(),
                TextColumn::make('category.name')->label('التصنيف')->sortable()->searchable(),
                TextColumn::make('name')->label('الاسم (عربي)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'ar')),
                TextColumn::make('name_en')->label('الاسم (إنجليزي)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'en')),
                IconColumn::make('active')->boolean()->label('نشط'),
                TextColumn::make('order')->label('الترتيب')->sortable(),
            ])->defaultSort('id', 'desc')
                ->filters([
                    SelectFilter::make('category_id')
                        ->label('التصنيف')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->default(null) // بدون تحديد افتراضي
                        ->placeholder('الكل')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGenres::route('/'),
            'create' => CreateGenre::route('/create'),
            'edit' => EditGenre::route('/{record}/edit'),
        ];
    }
}
