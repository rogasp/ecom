<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'polaris-product-list-icon';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make(__('Tabs')) // Översatt label för tabbar
                ->tabs([
                    Tab::make(__('Common'))
                            ->icon('akar-settings-horizontal')
                        ->schema([
                            TextInput::make('title')
                                ->label(__('Title'))
                                ->required()
                                ->minLength(2),
                            TextInput::make('slug')
                                ->label(__('Slug'))
                                ->required()
                                ->minLength(2),
                            TextInput::make('sku')
                                ->label(__('SKU')),
                            DatePicker::make('published_at')
                                ->label(__('Published At'))
                                ->required(),
                            DatePicker::make('available_at')
                                ->label(__('Available At'))
                                ->required(),
                            TextInput::make('price')
                                ->label(__('Price'))
                                ->numeric(),
                            Select::make('categories')
                                ->label(__('Categories'))
                                ->multiple()
                                ->relationship('categories', 'title'),
                        ]),
                    Tab::make(__('Content'))
                            ->icon('eos-content-lifecycle-management')
                        ->schema([
                            TiptapEditor::make('content')->profile('default')
                                ->output(TiptapOutput::Html)
                                ->maxContentWidth('5xl')
                                ->label(__('Content'))
                                ->required(),
                        ]),
                    Tab::make(__('Media'))
                        ->icon('bi-images')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                                ->label(__('Images'))
                                ->image()
                                ->disk('media')
                                ->multiple()
                                ->optimize('webp')
                                ->imageEditor(),
                        ]),
                    Tab::make(__('SEO'))
                        ->icon('iconpark-seo')
                        ->schema([
                            TextInput::make('meta_title')
                                ->label(__('Meta Title')),
                            TextInput::make('meta_description')
                                ->label(__('Meta Description')),
                            TextInput::make('meta_keywords')
                                ->label(__('Meta Keywords')),
                            TextInput::make('canonical_url')
                                ->label(__('Canonical URL')),

                        ]),
                    Tab::make(__('Other'))
                        ->icon('tabler-dimensions')
                        ->schema([
                            TextInput::make('dimensions.width')
                                ->label(__('Width (cm)'))
                                ->numeric()
                                ->rules('integer', 'min:0')
                                ->required(),
                            TextInput::make('dimensions.height')
                                ->label(__('Height (cm)'))
                                ->numeric()
                                ->rules('integer', 'min:0')
                                ->required(),
                            TextInput::make('dimensions.length')
                                ->label(__('Length (cm)'))
                                ->numeric()
                                ->rules('integer', 'min:0')
                                ->required(),
                            TextInput::make('weight')
                                ->label(__('Weight'))
                                ->numeric(),
                            Hidden::make('user_id')
                                ->dehydrateStateUsing(fn ($state) => Auth::id()),
                        ]),
                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('images'),
                TextColumn::make('title')->label(__('Title'))
                    ->searchable(),
                TextColumn::make('slug')->label(__('Slug'))
                    ->searchable(),
                TextColumn::make('price')->label(__('Price'))
                    ->formatStateUsing(fn ($state) => money($state)),
                TextColumn::make('sku')->label(__('SKU'))
                    ->searchable(),
                TextColumn::make('published_at')->label(__('Published At')),
                TextColumn::make('categories.title')->label(__('Categories'))
                    ->searchable()
                    ->badge(),
                TextColumn::make('dimensions')
                    ->label(__('Dimensions'))
                    ->getStateUsing(fn (Product $record): ?string => $record->dimensions ? implode(' x ', $record->dimensions) . ' cm' : null),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->label(__('Categories'))
                    ->multiple()
                    ->relationship('categories', 'title'),
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(ProductStatus::options()),
                SelectFilter::make('is_available')
                    ->label(__('Available Now'))
                    ->options([
                        '1' => __('Yes'),
                        '0' => __('No'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['value'] === '1') {
                            return $query->where('available_at', '<=', now());
                        } else {
                            return $query->where('available_at', '>', now());
                        }
                    }),
                SelectFilter::make('product_type')
                    ->label(__('Product Type'))
                    ->options(ProductType::options()),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
