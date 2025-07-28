<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Str;

class Permission extends SpatiePermission
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // public function getEntityAttribute(): string
    // {
    //     return explode('-', $this->name)[1] ?? '-';
    // }

    public function getGroupKeyAttribute(): string
    {
        return explode('-', $this->name)[1] ?? 'other';
    }
}
