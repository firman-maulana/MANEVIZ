<?php

namespace App\Filament\Resources\InspirationalOutfitResource\Pages;

use App\Filament\Resources\InspirationalOutfitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInspirationalOutfit extends EditRecord
{
    protected static string $resource = InspirationalOutfitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
