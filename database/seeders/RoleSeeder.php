<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['name' => 'superadmin'],
            ['guard_name' => 'web']
        );

        Role::firstOrCreate(
            ['name' => 'admin-sampah'],
            ['guard_name' => 'web']
        );

        Role::firstOrCreate(
            ['name' => 'admin-pohon'],
            ['guard_name' => 'web']
        );
    }
}
