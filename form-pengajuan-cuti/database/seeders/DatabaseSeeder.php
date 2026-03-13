<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'HRD Admin',
            'email' => 'hrd@test.com',
            'password' => bcrypt('password123'),
            'role' => 'hrd',
            'nik' => 'HR-001',
            'jabatan' => 'HR Manager',
            'bagian' => 'Human Resources'
        ]);

        $employee = User::factory()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password123'),
            'role' => 'employee',
            'nik' => 'EMP-12345',
            'jabatan' => 'Staff IT',
            'bagian' => 'Information Technology'
        ]);

        User::factory()->create([
            'name' => 'Security Guard',
            'email' => 'security@test.com',
            'password' => bcrypt('password123'),
            'role' => 'security',
            'nik' => 'SEC-007',
            'jabatan' => 'Chief Security',
            'bagian' => 'General Affairs'
        ]);
    }
}
