<?php

namespace App\Filament\Resources\BerandaImageResource\Pages;

use App\Filament\Resources\BerandaImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBerandaImage extends CreateRecord
{
    protected static string $resource = BerandaImageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Gambar berhasil ditambahkan';
    }
}
