<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CommonUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['username' => 'testBySeeder'],
            [
                'id' => 10,
                'name' => 'Test By Seeder',
                'password' => bcrypt('test123'),
            ]
        );

        $user->assignRole('admin-sampah');
    }
}
