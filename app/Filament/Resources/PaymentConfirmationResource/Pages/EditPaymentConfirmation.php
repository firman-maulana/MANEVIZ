<?php
// app/Filament/Resources/PaymentConfirmationResource/Pages/EditPaymentConfirmation.php

namespace App\Filament\Resources\PaymentConfirmationResource\Pages;

use App\Filament\Resources\PaymentConfirmationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPaymentConfirmation extends EditRecord
{
    protected static string $resource = PaymentConfirmationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Update verified_at and verified_by when status changes to verified
        if ($data['status'] === 'verified' && $this->record->status !== 'verified') {
            $data['verified_at'] = now();
            $data['verified_by'] = Auth::check() ? Auth::id() : null;
        } elseif ($data['status'] === 'rejected' && $this->record->status !== 'rejected') {
            $data['verified_at'] = now();
            $data['verified_by'] = Auth::check() ? Auth::id() : null;
        }

        return $data;
    }
}