<?php

namespace App\Filament\Resources\TaxRegulations\Pages;

use App\Filament\Resources\TaxRegulations\TaxRegulationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTaxRegulations extends ManageRecords
{
    protected static string $resource = TaxRegulationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
