<?php

namespace App\Filament\Resources\AboutContentResource\Pages;

use App\Filament\Resources\AboutContentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutContent extends CreateRecord
{
    protected static string $resource = AboutContentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'About content created successfully';
    }
}
