<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Super Admin',       'email' => 'admin@royalwedding.id',   'role' => 'super_admin',     'password' => 'password123'],
            ['name' => 'Ully Sjah',         'email' => 'ully@royalwedding.id',    'role' => 'wedding_planner', 'password' => 'password123'],
            ['name' => 'Finance Officer',   'email' => 'finance@royalwedding.id', 'role' => 'finance',         'password' => 'password123'],
            ['name' => 'Demo Client',       'email' => 'client@royalwedding.id',  'role' => 'client',          'password' => 'password123'],
        ];

        foreach ($users as $data) {
            User::create([
                'name'              => $data['name'],
                'email'             => $data['email'],
                'role'              => $data['role'],
                'password'          => Hash::make($data['password']),
                'email_verified_at' => now(),
                'is_active'         => true,
            ]);
        }
    }
}
