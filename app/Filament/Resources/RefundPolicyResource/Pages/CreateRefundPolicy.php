<?php

namespace App\Filament\Resources\RefundPolicyResource\Pages;

use App\Filament\Resources\RefundPolicyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRefundPolicy extends CreateRecord
{
    protected static string $resource = RefundPolicyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
