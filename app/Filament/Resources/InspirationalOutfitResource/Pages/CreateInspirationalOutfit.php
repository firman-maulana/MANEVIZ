<?php

namespace App\Filament\Resources\InspirationalOutfitResource\Pages;

use App\Filament\Resources\InspirationalOutfitResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInspirationalOutfit extends CreateRecord
{
    protected static string $resource = InspirationalOutfitResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
