<?php

namespace App\Filament\Resources\FeaturedItemResource\Pages;

use App\Filament\Resources\FeaturedItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeaturedItems extends ListRecords
{
    protected static string $resource = FeaturedItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
