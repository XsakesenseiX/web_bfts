<?php

namespace App\Filament\Resources\StudentVerificationResource\Pages;

use App\Filament\Resources\StudentVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

    class CreateStudentVerification extends CreateRecord
{
    protected static string $resource = StudentVerificationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
