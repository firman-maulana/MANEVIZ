<?php
// app/Filament/Resources/PaymentConfirmationResource/Pages/ViewPaymentConfirmation.php

namespace App\Filament\Resources\PaymentConfirmationResource\Pages;

use App\Filament\Resources\PaymentConfirmationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentConfirmation extends ViewRecord
{
    protected static string $resource = PaymentConfirmationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}