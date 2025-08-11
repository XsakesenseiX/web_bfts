<?php

namespace App\Filament\Resources\TransactionProofResource\Pages;

use App\Filament\Resources\TransactionProofResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionProof extends EditRecord
{
    protected static string $resource = TransactionProofResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
