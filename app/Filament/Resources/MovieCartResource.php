<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use App\Filament\Resources\MovieCartResource\Pages\ListMovieCarts;
use App\Filament\Resources\MovieCartResource\Pages\CreateMovieCart;
use App\Filament\Resources\MovieCartResource\Pages\EditMovieCart;
use App\Filament\Resources\MovieCartResource\Pages\ViewMovieCart;
use App\Filament\Resources\ItemsRelationManagerResource\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\DetailsRelationManagerResource\RelationManagers\DetailsRelationManager;
use App\Filament\Resources\MovieCartResource\Pages;
use App\Filament\Resources\MovieCartResource\RelationManagers;
use App\Models\MovieCart;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class MovieCartResource extends Resource
{
    protected static ?string $model = MovieCart::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getLabel(): ?string
    {
        return 'طلبات العملاء';
    }
    protected static ?int $navigationSort = 4;

    public static function getPluralLabel(): ?string
    {
        return 'طلبات العملاء';
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('العميل')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required() ->disabled() ,
                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار من الستخدم',
                        'confirmed' => 'تم تاكيده من المستخدم',
                        'approved' => 'مقبول',
                        'cancelled' => 'ملغي',
                    ])
                    ->disabled(fn (string $context) => $context === 'view'),

//                TextInput::make('status')
//                    ->label('الحالة')
//                    ->disabled(),

                Textarea::make('note')
                    ->label('ملاحظة')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('رقم سلة العميل '),
                TextColumn::make('user.name')
                    ->label('اسم العميل')
                    ->searchable()
                    ->sortable(),                TextColumn::make('status')->label('حالة السلة'),
                TextColumn::make('note')->label('ملاحظة'),
            ])->recordActions([
                 EditAction::make(),
            ]) ->defaultSort('id', 'desc')
            ->paginated(true);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMovieCarts::route('/'),
            'create' => CreateMovieCart::route('/create'),
            'edit' => EditMovieCart::route('/{record}/edit'),
            'view' => ViewMovieCart::route('/{record}'),
        ];
    }
}
