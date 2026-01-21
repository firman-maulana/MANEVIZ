<?php

namespace App\Filament\Resources\RefundPolicyResource\Pages;

use App\Filament\Resources\RefundPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefundPolicy extends EditRecord
{
    protected static string $resource = RefundPolicyResource::class;

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
}
