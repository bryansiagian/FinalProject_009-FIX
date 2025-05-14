<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Import the User model

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'), // Ganti 'password' dengan password yang lebih aman
            'shipping_address' => '',
            'phone_number' => '',
            'role' => 'admin',
        ]);

        // Customer User
        User::create([
            'name' => 'Bryan',
            'email' => 'bryan@gmail.com',
            'password' => Hash::make('bryan12345'), // Ganti 'password' dengan password yang lebih aman
            'shipping_address' => 'Jl. Pematang Siantar No. 316',
            'phone_number' => '081219208312',
            'role' => 'customer',
        ]);
    }
}