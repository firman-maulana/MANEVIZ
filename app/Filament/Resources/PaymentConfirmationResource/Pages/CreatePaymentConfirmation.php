<?php
// app/Filament/Resources/PaymentConfirmationResource/Pages/CreatePaymentConfirmation.php

namespace App\Filament\Resources\PaymentConfirmationResource\Pages;

use App\Filament\Resources\PaymentConfirmationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentConfirmation extends CreateRecord
{
    protected static string $resource = PaymentConfirmationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}