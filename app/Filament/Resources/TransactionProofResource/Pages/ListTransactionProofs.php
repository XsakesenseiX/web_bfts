<?php

namespace App\Filament\Resources\TransactionProofResource\Pages;

use App\Filament\Resources\TransactionProofResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionProofs extends ListRecords
{
    protected static string $resource = TransactionProofResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action as this is read-only resource for approved transactions
        ];
    }

    public function getPollingInterval(): ?string
    {
        return '5s'; // Auto-refresh every 5 seconds
    }
}
