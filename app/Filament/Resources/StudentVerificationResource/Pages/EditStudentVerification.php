<?php

namespace App\Filament\Resources\StudentVerificationResource\Pages;

use App\Filament\Resources\StudentVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentVerification extends EditRecord
{
    protected static string $resource = StudentVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
