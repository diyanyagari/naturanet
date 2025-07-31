<?php

namespace App\Filament\Resources\BankSampahResource\Pages;

use App\Filament\Resources\BankSampahResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBankSampah extends CreateRecord
{
    protected static string $resource = BankSampahResource::class;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
}
