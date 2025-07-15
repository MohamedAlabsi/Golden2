<?php

namespace App\Filament\Resources\ItemsRelationManagerResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'عناصر السلة';
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('اسم الفيلم'),
                ImageColumn::make('image')
                    ->label('الصورة')
                    ->height(60)
                ->url(fn ($record) => $record->image)
                ->openUrlInNewTab()
                    ->width(100),
                TextColumn::make('note')->label(''),
//                Tables\Columns\TextColumn::make('movie_id')->label('رقم الفيلم'),
//                Tables\Columns\TextColumn::make('note')->label('ملاحظة'),
            ])
            ->headerActions([])
            ->recordActions([]);
//        return $table
//            ->recordTitleAttribute('name')
//            ->columns([
//                Tables\Columns\TextColumn::make('name'),
//            ])
//            ->filters([
//                //
//            ])
//            ->headerActions([
//                Tables\Actions\CreateAction::make(),
//            ])
//            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
//            ])
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ]);
    }
}
