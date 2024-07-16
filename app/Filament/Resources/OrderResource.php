<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'polaris-order-first-icon';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_id')
                    ->label(__('Order id'))
                    ->disabled(),
                TextInput::make('email')
                    ->email()
                    ->label(__('Email')),
                Select::make('status')
                    ->label(__('Order status'))
                    ->options(OrderStatus::options()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')
                    ->label(__('Order id')),
                TextColumn::make('email')
                    ->label(__('Email')),
                SelectColumn::make('status')
                    ->options(OrderStatus::options())
                    ->label(__('OrderStatus')),
                TextColumn::make('taxes')
                    ->label(__('Taxes'))
                    ->formatStateUsing(fn ($state) => money($state ?? '0')),
                TextColumn::make('discount')
                    ->label(__('Discount'))
                    ->formatStateUsing(fn ($state) => money($state ?? '0')),
                TextColumn::make('total')
                    ->label(__('Total'))
                    ->formatStateUsing(fn ($state) => money($state ?? '0')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
