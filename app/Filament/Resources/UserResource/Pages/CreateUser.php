<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }

    protected string|null $roleName = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->roleName = $data['role'] ?? null;
        unset($data['role']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $role = $this->roleName;
        if ($role) {
            $this->record->assignRole($role);
        }
    }
}
