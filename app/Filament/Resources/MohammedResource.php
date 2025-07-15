<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\MohammedResource\Pages\ListMohammeds;
use App\Filament\Resources\MohammedResource\Pages\CreateMohammed;
use App\Filament\Resources\MohammedResource\Pages\EditMohammed;
use App\Filament\Resources\MohammedResource\Pages;
use App\Filament\Resources\MohammedResource\RelationManagers;
use App\Models\Mohammed;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MohammedResource extends Resource
{
    protected static ?string $model = Mohammed::class;

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
            'index' => ListMohammeds::route('/'),
            'create' => CreateMohammed::route('/create'),
            'edit' => EditMohammed::route('/{record}/edit'),
        ];
    }
}
