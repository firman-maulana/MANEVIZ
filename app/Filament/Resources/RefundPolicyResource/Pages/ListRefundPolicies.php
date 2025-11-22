<?php

namespace App\Filament\Resources\RefundPolicyResource\Pages;

use App\Filament\Resources\RefundPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefundPolicies extends ListRecords
{
    protected static string $resource = RefundPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
