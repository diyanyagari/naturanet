<?php

namespace App\Filament\Resources\BankSampahResource\Pages;

use App\Filament\Resources\BankSampahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankSampahs extends ListRecords
{
    protected static string $resource = BankSampahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
