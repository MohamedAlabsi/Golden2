<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\MoviesResource\Pages\ListMovies;
use App\Filament\Resources\MoviesResource\Pages\CreateMovies;
use App\Filament\Resources\MoviesResource\Pages\EditMovies;
use Filament\Actions\Action;
use App\Filament\Resources\MoviesResource\Pages;
use App\Filament\Resources\MoviesResource\RelationManagers;
use App\Models\Movies;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MoviesResource extends Resource
{
    protected static ?string $model = Movies::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => ListMovies::route('/'),
            'create' => CreateMovies::route('/create'),
            'edit' => EditMovies::route('/{record}/edit'),
        ];
    }

    public static function getGlobalActions(): array
    {
        return [
            Action::make('newMovies')
                ->label('New Movies')
                ->url(fn() => route('filament.pages.tmdb-movies'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
