<?php

namespace App\Filament\Resources\HowToOrderStepResource\Pages;

use App\Filament\Resources\HowToOrderStepResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHowToOrderStep extends EditRecord
{
    protected static string $resource = HowToOrderStepResource::class;

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
