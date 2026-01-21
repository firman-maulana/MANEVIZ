<?php

namespace App\Filament\Resources\FeaturedItemResource\Pages;

use App\Filament\Resources\FeaturedItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeaturedItem extends EditRecord
{
    protected static string $resource = FeaturedItemResource::class;

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
