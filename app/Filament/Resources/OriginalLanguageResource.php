<?php

namespace App\Filament\Resources;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use App\Filament\Resources\OriginalLanguageResource\Pages\ListOriginalLanguages;
use App\Filament\Resources\OriginalLanguageResource\Pages\CreateOriginalLanguage;
use App\Filament\Resources\OriginalLanguageResource\Pages\EditOriginalLanguage;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\OriginalLanguageResource\Pages;
use App\Filament\Resources\OriginalLanguageResource\RelationManagers;
use App\Models\OriginalLanguage;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
class OriginalLanguageResource extends Resource
{
    protected static ?string $model = OriginalLanguage::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return 'قائمة اللغات للفلترة';
    }
    protected static ?int $navigationSort = 4;

    public static function getPluralLabel(): ?string
    {
        return 'قائمة اللغات للفلترة';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name.ar')
                        ->label('الاسم بالعربية')
                        ->required(),

                    TextInput::make('name.en')
                        ->label('الاسم بالإنجليزية')
                        ->required(),
                ]),

                TextInput::make('value')
                    ->label('رمز اللغة (مثلاً: ko أو zh)')
                    ->required()
                    ->maxLength(191),

                Toggle::make('active')
                    ->label('نشط')
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('name')
                    ->label('الاسم بالعربية')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('الاسم')
                    ->formatStateUsing(function ($state) {
                        return $state ;
                    }),

                TextColumn::make('value')
                    ->label('الكود'),

                IconColumn::make('active')
                    ->label('نشط')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('أنشئ في')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('تم التحديث')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => ListOriginalLanguages::route('/'),
            'create' => CreateOriginalLanguage::route('/create'),
            'edit' => EditOriginalLanguage::route('/{record}/edit'),
        ];
    }
}
