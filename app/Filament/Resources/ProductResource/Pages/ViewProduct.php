<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromForm()
                        ->withFilename(fn ($query) => $query->first()->name),
                ]),
        ]);
    }
}
