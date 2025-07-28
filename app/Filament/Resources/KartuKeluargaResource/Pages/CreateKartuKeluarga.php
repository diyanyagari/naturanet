<?php

namespace App\Filament\Resources\KartuKeluargaResource\Pages;

use App\Filament\Resources\KartuKeluargaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKartuKeluarga extends CreateRecord
{
    protected static string $resource = KartuKeluargaResource::class;
    protected array $anggotaData = [];

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }

    public function getTitle(): string
    {
        return 'Tambah Kartu Keluarga Baru';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->anggotaData = $data['anggota'] ?? [];
        unset($data['anggota']);
        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->anggotaData as $anggota) {
            $this->record->anggota()->attach($anggota['customer_id'], [
                'hubungan' => $anggota['hubungan'],
            ]);
        }
    }
}
