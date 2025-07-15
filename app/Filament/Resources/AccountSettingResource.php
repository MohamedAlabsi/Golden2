<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\AccountSettingResource\Pages\ListAccountSettings;
use App\Filament\Resources\AccountSettingResource\Pages\CreateAccountSetting;
use App\Filament\Resources\AccountSettingResource\Pages\EditAccountSetting;
use App\Filament\Resources\AccountSettingResource\Pages;
use App\Filament\Resources\AccountSettingResource\RelationManagers;
use App\Models\AccountSetting;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\Card;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
class AccountSettingResource extends Resource
{
    protected static ?string $model = AccountSetting::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('show_movies_only')
                    ->required(),
                Toggle::make('show_movies_all')
                    ->required(),
                Toggle::make('show_series_only')
                    ->required(),
                Toggle::make('show_series_all')
                    ->required(),
                Toggle::make('notification')
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Stack::make([
                Split::make([
                    CheckboxColumn::make('is_admin') ,

                    TextColumn::make('name') ,
                    TextColumn::make('email') ,
                ])

            ]),
        ])
        ->contentGrid([
            'md' => 2,
            'xl' => 3,
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
            'index' => ListAccountSettings::route('/'),
            'create' => CreateAccountSetting::route('/create'),
            'edit' => EditAccountSetting::route('/{record}/edit'),
        ];
    }
}
