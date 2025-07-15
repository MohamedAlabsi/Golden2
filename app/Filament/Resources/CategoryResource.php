<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return 'الاقسام';
    }
    protected static ?int $navigationSort = 5;

    public static function getPluralLabel(): ?string
    {
        return 'الاقسام';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name.ar')
                ->label('الاسم (عربي)')
                ->required(),

            TextInput::make('name.en')
                ->label('الاسم (إنجليزي)')
                ->required(),

            Toggle::make('in_home')
                ->label('عرض في الواجهة الرئيسية')
                ->default(false),

//            Forms\Components\Toggle::make('in_home')
//                ->label('عرض في الواجهة الرئيسية')
//                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم (عربي)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'ar')),
                TextColumn::make('name_en')->label('الاسم (إنجليزي)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'en')),
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
