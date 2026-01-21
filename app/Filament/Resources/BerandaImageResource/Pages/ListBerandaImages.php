<?php

namespace App\Filament\Resources\BerandaImageResource\Pages;

use App\Filament\Resources\BerandaImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBerandaImages extends ListRecords
{
    protected static string $resource = BerandaImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Gambar Baru'),
        ];
    }
}
