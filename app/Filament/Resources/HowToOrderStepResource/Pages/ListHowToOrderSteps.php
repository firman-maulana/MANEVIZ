<?php

namespace App\Filament\Resources\HowToOrderStepResource\Pages;

use App\Filament\Resources\HowToOrderStepResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHowToOrderSteps extends ListRecords
{
    protected static string $resource = HowToOrderStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
