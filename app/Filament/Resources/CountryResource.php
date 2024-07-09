<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'govicon-world';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('flag_url')
                    ->label('Flag')
                    ->width(50)
                    ->height(30),
                TextColumn::make('common_name')
                    ->label('Name'),
                TextColumn::make('cca2')
                    ->label('Code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('region')
                    ->label('Region')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subregion')
                    ->label('Subregion')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if ($search = request('tableSearch')) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('cca2', 'ilike', "%{$search}%")
                        ->orWhere('region', 'ilike', "%{$search}%")
                        ->orWhere('subregion', 'ilike', "%{$search}%");
                }

                // Laravel sortering kräver en faktisk kolumn. Vi kan bara sortera efter en kolumn.
                if ($sortColumn = request('sort')) {
                    if ($sortColumn === 'common_name') {
                        // Hämta alla resultat och sortera dem efter 'common_name'
                        $results = $query->get()->sortBy(function ($country) use ($sortColumn) {
                            return $country->{$sortColumn};
                        }, SORT_REGULAR, request('direction', 'asc') === 'desc');

                        // Returnera en ny Eloquent Collection som en mock Builder
                        $query = Country::query()->whereIn('id', $results->pluck('id'));
                    } else {
                        $query->orderBy($sortColumn, request('direction', 'asc'));
                    }
                }

                return $query;
            })
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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
