<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\SortOptionResource\Pages\ListSortOptions;
use App\Filament\Resources\SortOptionResource\Pages\CreateSortOption;
use App\Filament\Resources\SortOptionResource\Pages\EditSortOption;
use App\Filament\Resources\SortOptionResource\Pages;
use App\Filament\Resources\SortOptionResource\RelationManagers;
use App\Models\Category;
use App\Models\SortOption;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SortOptionResource extends Resource
{
    protected static ?string $model = SortOption::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getLabel(): ?string
    {
        return 'الترتيب بحسب';
    }
    protected static ?int $navigationSort = 7;

    public static function getPluralLabel(): ?string
    {
        return 'الترتيب بحسب';
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('نوع التصنيف')
                    ->options(
                        Category::query()
                            ->whereIn('id', [1, 2])
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name') ->label('الاسم')
                    ->required()
                    ->maxLength(191),
                TextInput::make('key') ->label('المفتاح')
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('category.name')
                ->label('القسم')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable(),
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
                //
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
            'index' => ListSortOptions::route('/'),
            'create' => CreateSortOption::route('/create'),
            'edit' => EditSortOption::route('/{record}/edit'),
        ];
    }
}
