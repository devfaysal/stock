<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Stock;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->shariah();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')->required(),
                Forms\Components\TextInput::make('company')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                ->description(fn (Stock $record): string => $record->company)
                ->searchable(),
                Tables\Columns\BooleanColumn::make('cse_shariah')->label('Shariah'),
                Tables\Columns\BooleanColumn::make('dse_30')->label('DSE 30'),
                Tables\Columns\BooleanColumn::make('cse_30')->label('CSE 30'),
                Tables\Columns\TextColumn::make('dse')
                ->getStateUsing(function (Stock $record) {
                    return $record->code;
                })
                ->url(function(Stock $record){
                    return 'https://www.dsebd.org/displayCompany.php?name=' . $record->code;
                })
                ->label('DSE')
                ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('amar_stock')
                ->getStateUsing(function (Stock $record) {
                    return $record->code;
                })
                ->url(function(Stock $record){
                    return 'https://www.amarstock.com/stock/' . $record->code;
                })
                ->label('Amar Stock')
                ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('stock_now')
                ->getStateUsing(function (Stock $record) {
                    return $record->code;
                })
                ->url(function(Stock $record){
                    return 'https://stocknow.com.bd/search?symbol=' . $record->code;
                })
                ->label('Stock Now')
                ->openUrlInNewTab(),
            ])
            ->filters([
                Filter::make('dse_30')
                ->query(fn (Builder $query): Builder => $query->where('dse_30', true)),
                Filter::make('cse_30')
                ->query(fn (Builder $query): Builder => $query->where('cse_30', true))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }    
}
