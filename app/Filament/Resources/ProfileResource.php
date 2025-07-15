<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use App\Filament\Resources\ProfileResource\Pages\ListProfiles;
use App\Filament\Resources\ProfileResource\Pages\EditProfile;
use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\RelationManagers;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function canCreate(): bool
    {
        return false;
    }



    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('shop_name')
                ->required()
                ->label('Shop Name'),
                SpatieMediaLibraryFileUpload::make('shop_logo')->label(__("filament.logo"))-> collection('shop_logo') ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                TextColumn::make('shop_name')->sortable()->searchable(),
                SpatieMediaLibraryImageColumn::make('shop_logo')->label(__("filament.shop_logo")) ->collection('shop_logo'),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([

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
            'index' => ListProfiles::route('/'),
            // 'create' => Pages\CreateProfile::route('/create'),
            'edit' => EditProfile::route('/{record}/edit'),
        ];
    }
}
