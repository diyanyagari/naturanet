<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ]);

        $user = User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
            ]
        );

        $user->assignRole($role);
    }
}
