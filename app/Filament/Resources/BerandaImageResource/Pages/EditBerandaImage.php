<?php

namespace App\Filament\Resources\BerandaImageResource\Pages;

use App\Filament\Resources\BerandaImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBerandaImage extends EditRecord
{
    protected static string $resource = BerandaImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function () {
                    // Hapus file lama dari storage
                    if (Storage::disk('public')->exists($this->record->image_path)) {
                        Storage::disk('public')->delete($this->record->image_path);
                    }
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Gambar berhasil diperbarui';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika gambar diubah, hapus gambar lama
        if (isset($data['image_path']) && $data['image_path'] !== $this->record->image_path) {
            if (Storage::disk('public')->exists($this->record->image_path)) {
                Storage::disk('public')->delete($this->record->image_path);
            }
        }

        return $data;
    }
}
