<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait HasFilamentPermissions
{
    // public static function canViewAny(): bool
    // {
    //     return Auth::user()?->can('view-' . static::getResourceName());
    // }

    // public static function canCreate(): bool
    // {
    //     return Auth::user()?->can('create-' . static::getResourceName());
    // }

    // public static function canEdit(Model $record): bool
    // {
    //     return Auth::user()?->can('edit-' . static::getResourceName());
    // }

    // public static function canDelete(Model $record): bool
    // {
    //     return Auth::user()?->can('delete-' . static::getResourceName());
    // }

    // protected static function getResourceName(): string
    // {
    //     return strtolower(class_basename(static::class));
    // }
}
