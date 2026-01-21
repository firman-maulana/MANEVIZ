<?php

namespace App\Filament\Resources\FeaturedItemResource\Pages;

use App\Filament\Resources\FeaturedItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeaturedItem extends CreateRecord
{
    protected static string $resource = FeaturedItemResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
