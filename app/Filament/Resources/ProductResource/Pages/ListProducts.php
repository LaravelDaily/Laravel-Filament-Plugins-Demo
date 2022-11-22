<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductResource;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('name')
                        ->helperText('Products name')
                        ->required(),
                    ImportField::make('is_visible')
                        ->label('Is visible')
                        ->required()
                        ->mutateBeforeCreate(function (string $value): bool {
                            if ($value === 'True') {
                                return true;
                            }

                            return false;
                        }),
                    ImportField::make('price')
                        ->required(),
                    ImportField::make('published_at')
                        ->required()
                        ->label('Published at'),
                ])
        ];
    }
}
