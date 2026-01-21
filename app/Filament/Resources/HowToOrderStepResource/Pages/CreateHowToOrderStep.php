<?php

namespace App\Filament\Resources\HowToOrderStepResource\Pages;

use App\Filament\Resources\HowToOrderStepResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHowToOrderStep extends CreateRecord
{
    protected static string $resource = HowToOrderStepResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
