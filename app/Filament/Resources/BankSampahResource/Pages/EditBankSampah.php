<?php

namespace App\Filament\Resources\BankSampahResource\Pages;

use App\Filament\Resources\BankSampahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBankSampah extends EditRecord
{
    protected static string $resource = BankSampahResource::class;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
