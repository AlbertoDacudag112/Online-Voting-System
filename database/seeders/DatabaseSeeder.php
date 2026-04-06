<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create([
            'name'      => 'Admin',
            'email'     => 'admin@example.com',
            'password'  => bcrypt('password123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
    }
}