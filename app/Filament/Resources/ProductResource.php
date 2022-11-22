<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\DatePicker;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\ProductResource\Pages;
use pxlrbt\FilamentExcel\Actions;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Checkbox::make('is_visible'),

                TextInput::make('price')
                    ->required(),

                DatePicker::make('published_at')
                    ->label('Published Date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_visible')
                    ->boolean(),

                TextColumn::make('price'),

                TextColumn::make('published_at')
                    ->label('Published Date')
                    ->date(),
            ])
            ->prependBulkActions([
                Actions\Tables\ExportBulkAction::make()
                    ->deselectRecordsAfterCompletion()
            ])
            ->prependHeaderActions([
                Actions\Tables\ExportAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->askForFilename()
                            ->askForWriterType()
                            ->withColumns([
                                Column::make('is_visible')
                                    ->formatStateUsing(fn ($state) => $state ? 'True' : 'False'),
                            ])
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
