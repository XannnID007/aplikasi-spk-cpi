<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nip' => 'ADM001',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Admin No. 1, Banjar',
            'is_active' => true
        ]);

        // Guru Users
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'guru1@gmail.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
            'nip' => 'GR001',
            'telepon' => '081234567891',
            'alamat' => 'Jl. Guru No. 1, Banjar',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Dewi Sartika',
            'email' => 'guru2@gmail.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
            'nip' => 'GR002',
            'telepon' => '081234567892',
            'alamat' => 'Jl. Guru No. 2, Banjar',
            'is_active' => true
        ]);
    }
}
