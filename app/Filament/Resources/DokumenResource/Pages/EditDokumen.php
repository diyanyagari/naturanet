<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;

class EditDokumen extends EditRecord
{
    protected static string $resource = DokumenResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['pdf'])) {
            $localPath = Storage::disk('public')->path($data['pdf']);

            $cloudinary = new Cloudinary();

            if ($this->record->public_id) {
                try {
                    $cloudinary->uploadApi()->destroy($this->record->public_id, ['resource_type' => 'raw']);
                } catch (\Throwable $e) { }
            }

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
        } else {
            unset($data['pdf']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Perubahan tersimpan';
    }
}
