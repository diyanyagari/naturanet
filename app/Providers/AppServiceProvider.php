<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Role;
use App\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SpatieRole::resolveRelationUsing('permissions', function ($roleModel) {
            return $roleModel->belongsToMany(
                Permission::class,
                config('permission.table_names.role_has_permissions'),
                'role_uuid', // foreign key on pivot
                'permission_uuid' // related key on pivot
            );
        });

        app()->bind(SpatieRole::class, Role::class);
        app()->bind(SpatiePermission::class, Permission::class);
    }
}
