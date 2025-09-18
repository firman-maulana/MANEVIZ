<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Jobs\SendNewProductNotificationJob;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    /**
     * Handle after the record is created
     */
    protected function afterCreate(): void
    {
        // Get the created product
        $product = $this->record;

        try {
            // Dispatch job to send email notifications
            SendNewProductNotificationJob::dispatch($product);
            
            // Show success notification to admin
            Notification::make()
                ->title('Produk Berhasil Ditambahkan! 🎉')
                ->body('Notifikasi email sedang dikirim ke semua pengguna.')
                ->success()
                ->duration(5000)
                ->send();
                
        } catch (\Exception $e) {
            // Show error notification if job dispatch fails
            Notification::make()
                ->title('Produk Ditambahkan')
                ->body('Produk berhasil ditambahkan, namun gagal mengirim notifikasi email.')
                ->warning()
                ->duration(5000)
                ->send();
                
            // Log the error
            Log::error('Failed to dispatch new product notification job: ' . $e->getMessage());
        }
    }

    /**
     * Get redirect URL after creation
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Get creation notification
     */
    protected function getCreatedNotification(): ?Notification
    {
        // We handle notifications in afterCreate(), so return null here
        return null;
    }
}