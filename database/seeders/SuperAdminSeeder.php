<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleName = env('SUPERADMIN_ROLE', 'superadmin');

        $role = Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => 'web',
        ]);

        $username = env('SUPERADMIN_USERNAME', 'superadmin');
        $password = env('SUPERADMIN_PASSWORD', 'password123');
        $name = env('SUPERADMIN_NAME', 'Super Admin');

        $user = User::firstOrCreate(
            ['username' => $username],
            [
                'uuid' => (string) Str::uuid(),
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        $user->assignRole($role);
    }
}
