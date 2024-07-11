<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationResource\Pages;
use App\Filament\Resources\NavigationResource\RelationManagers;
use App\Models\Navigation;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NavigationResource extends Resource
{
    protected static ?string $model = Navigation::class;

    protected static ?string $navigationIcon = 'bi-menu-button-wide';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('items')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('url')
                            ->required()
                            ->placeholder('/example-page'),
                        Checkbox::make('external_link')
                            ->label('Open in new tab'),
                    ]),
                Repeater::make('items_sidebar')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('url')
                            ->required()
                            ->placeholder('/example-page'),
                        Checkbox::make('external_link')
                            ->label('Open in new tab'),
                    ]),
                ColorPicker::make('bg_color')
                    ->label('Background Color'),
                Checkbox::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('bg_color'),
                CheckboxColumn::make('is_active'),
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
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigation::route('/create'),
            'edit' => Pages\EditNavigation::route('/{record}/edit'),
        ];
    }
}
