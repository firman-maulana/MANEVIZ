<?php

namespace App\Filament\Resources\InspirationalOutfitResource\Pages;

use App\Filament\Resources\InspirationalOutfitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInspirationalOutfits extends ListRecords
{
    protected static string $resource = InspirationalOutfitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
