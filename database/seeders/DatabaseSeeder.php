<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create([
            'name' => 'admin',
            'keterangan' => 'Administrator',
        ]);
        Role::create([
            'name' => 'user',
            'keterangan' => 'User Account',
        ]);
        Role::create([
            'name' => 'view',
            'keterangan' => 'Viewer Account',
        ]);
    }
}
