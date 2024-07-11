<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                                        TextInput::make('capital')
                                            ->columnSpan(2)
                                            ->label(__('Capital'))
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
                                        TextInput::make('cca2')
                                            ->label(__('CCA2'))
                                            ->required()
                                            ->maxLength(2)
                                            ->disabled(),
                                        TextInput::make('cca3')
                                            ->label(__('CCA3'))
                                            ->required()
                                            ->maxLength(3)
                                            ->disabled(),
                                        Placeholder::make('zip_format')
                                        ->label(__('Zip Format'))
                                        ->content(function ($record) {
                                            return $record->zip_format;
                                        }),
                                        Placeholder::make('')
                                            ->columnSpan(1),
                                    ])
                            ])->columnSpan(2), // Vänster kolumn tar upp 2/3 av utrymmet
                        // Höger kolumn (1/3)
                        Section::make(__('Additional Info'))
                            ->schema([
                                Placeholder::make('flag_url')
                                    ->label(__('Flag'))
                                    ->content(function ($record) {
                                        return view('livewire.image-view', [
                                            'url' => $record->flag_url,
                                            'width' => 100,
                                            'height' => 30,
                                        ]);
                                    }),
                                Placeholder::make('coat_of_arms_url')
                                    ->label(__('Coat of Arms'))
                                    ->content(function ($record) {
                                        return view('livewire.image-view', [
                                            'url' => $record->coat_of_arms_url,
                                            'width' => 200,
                                            'height' => 180,
                                        ]);
                                    }),

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
                    ->width(30)
                    ->height(18),
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
                Tables\Actions\EditAction::make()->slideOver(),
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
