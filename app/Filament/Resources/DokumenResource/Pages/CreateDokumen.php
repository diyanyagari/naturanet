<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;

class CreateDokumen extends CreateRecord
{
    protected static string $resource = DokumenResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['pdf'])) {
            $localPath = Storage::disk('public')->path($data['pdf']);

            $cloudinary = new Cloudinary();

            $upload = $cloudinary->uploadApi()->upload(
                $localPath,
                [
                    'folder' => 'naturanet',
                    'resource_type' => 'raw',
                    'type' => 'upload',
                    'access_mode' => 'public',
                    'use_filename' => true,
                    'unique_filename' => false,
                    'overwrite' => true,
                ]
            );

            $data['public_id'] = $upload['public_id'];
            $data['secure_url'] = $upload['secure_url'];
            $data['ukuran'] = $upload['ukuran']  ?? null;
            $data['format'] = $upload['format'] ?? null;

            Storage::disk('public')->delete($data['pdf']);
            unset($data['pdf']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Dokumen berhasil diunggah';
    }
}
