<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Forms\Components\ImageView;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'govicon-world';

    public Country $record;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        // Vänster kolumn (4 kolumner)
                        Section::make(__('Country Details'))
                            ->schema([
                                Grid::make(4)
                                    ->schema(components: [
                                        TextInput::make('common_name')
                                            ->label(__('Name'))
                                            ->columnSpan(2)
                                            ->required()
                                            ->disabled(),
                                        Toggle::make('independent')
                                            ->label(__('Independent'))
                                            ->disabled(),
                                        Toggle::make('un_member')
                                            ->label(__('UN Member'))
                                            ->disabled(),
                                        TextInput::make('capital')
                                            ->columnSpan(2)
                                            ->label(__('Capital'))
                                            ->required()
                                            ->disabled(),
                                        ImageView::make('flag_url')
                                            ->url('')
                                            ->width(50)
                                            ->height(30),

                                        TextInput::make('cca2')
                                            ->label(__('CCA2'))
                                            ->required()
                                            ->maxLength(2)
                                            ->disabled(),
                                        TextInput::make('status')
                                            ->label(__('Status'))
                                            ->required()
                                            ->disabled(),
                                        TextInput::make('region')
                                            ->label(__('Region'))
                                            ->required()
                                            ->columnSpan(2)
                                            ->disabled(),
                                        TextInput::make('subregion')
                                            ->label(__('Subregion'))
                                            ->columnSpan(2)
                                            ->disabled(),

                                        TextInput::make('ccn3')
                                            ->label(__('CCN3'))
                                            ->required()
                                            ->maxLength(3)
                                            ->disabled(),
                                        TextInput::make('cca3')
                                            ->label(__('CCA3'))
                                            ->required()
                                            ->maxLength(3)
                                            ->disabled(),
                                        TextInput::make('cioc')
                                            ->label(__('CIOC'))
                                            ->maxLength(3)
                                            ->disabled(),

                                        Textarea::make('languages')
                                            ->label(__('Languages'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('translations')
                                            ->label(__('Translations'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('latlng')
                                            ->label(__('Lat/Lng'))
                                            ->required()
                                            ->disabled(),

                                        Textarea::make('demonyms')
                                            ->label(__('Demonyms'))
                                            ->required()
                                            ->disabled(),
                                        TextInput::make('flag')
                                            ->label(__('Flag'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('maps')
                                            ->label(__('Maps'))
                                            ->required()
                                            ->disabled(),

                                        Textarea::make('timezones')
                                            ->label(__('Timezones'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('continents')
                                            ->label(__('Continents'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('flags')
                                            ->label(__('Flags'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('coatOfArms')
                                            ->label(__('Coat of Arms'))
                                            ->disabled(),
                                        TextInput::make('startOfWeek')
                                            ->label(__('Start of Week'))
                                            ->required()
                                            ->disabled(),
                                        Textarea::make('capitalInfo')
                                            ->label(__('Capital Info'))
                                            ->disabled(),
                                        Textarea::make('postalCode')
                                            ->label(__('Postal Code'))
                                            ->disabled(),
                                    ])
                            ])->columnSpan(2), // Vänster kolumn tar upp 2/3 av utrymmet
                        // Höger kolumn (1/3)
                        Section::make(__('Additional Info'))
                            ->schema([
                                TextInput::make('tld')
                                    ->label(__('TLD'))
                                    ->required()
                                    ->disabled(),
                                Textarea::make('currencies')
                                    ->label(__('Currencies'))
                                    ->required()
                                    ->disabled(),
                                Textarea::make('idd')
                                    ->label(__('IDD'))
                                    ->required()
                                    ->disabled(),
                                Toggle::make('landlocked')
                                    ->label(__('Landlocked'))
                                    ->disabled(),
                                TextInput::make('area')
                                    ->label(__('Area'))
                                    ->numeric()
                                    ->required()
                                    ->disabled(),
                                TextInput::make('population')
                                    ->label(__('Population'))
                                    ->numeric()
                                    ->required()
                                    ->disabled(),
                                Textarea::make('gini')
                                    ->label(__('Gini'))
                                    ->disabled(),
                                TextInput::make('fifa')
                                    ->label(__('FIFA'))
                                    ->maxLength(3)
                                    ->disabled(),
                                Textarea::make('car')
                                    ->label(__('Car'))
                                    ->required()
                                    ->disabled(),
                            ])->columnSpan(1), // Höger kolumn tar upp 1/3 av utrymmet
                    ])->columns(3),
            ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('flag_url')
                    ->label(__('Flag'))
                    ->width(50)
                    ->height(30),
                TextColumn::make('common_name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Name')),
                TextColumn::make('cca2')
                    ->label(__('Code'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('region')
                    ->label(__('Region'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subregion')
                    ->label(__('Subregion'))
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label(__('Status'))
                    ->default()
                    ->options([
                        true => __('Active'),
                        false => __('Inactive')
                    ])
            ])
            ->defaultSort('common_name')
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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
