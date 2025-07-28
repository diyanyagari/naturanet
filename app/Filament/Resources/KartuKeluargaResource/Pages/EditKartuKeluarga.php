<?php

namespace App\Filament\Resources\KartuKeluargaResource\Pages;

use App\Filament\Resources\KartuKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\KartuKeluarga;

class EditKartuKeluarga extends EditRecord
{
    protected static string $resource = KartuKeluargaResource::class;
    protected array $anggotaData = [];


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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->anggotaData = $data['anggota'] ?? [];
        unset($data['anggota']);
        return $data;
    }

    protected function afterSave(): void
    {
        // Clear existing anggota
        $this->record->anggota()->detach();

        // Re-attach new anggota
        foreach ($this->anggotaData as $anggota) {
            $this->record->anggota()->attach($anggota['customer_id'], [
                'hubungan' => $anggota['hubungan'],
            ]);
        }
    }

    protected function resolveRecord($key): KartuKeluarga
    {
        return static::getModel()::with('anggota')->findOrFail($key);
    }
}
