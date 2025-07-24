<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminadmin'),
            'role' => 'admin',
        ]);

        // Customer Account
        User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customercustomer'),
            'role' => 'customer',
        ]);

        // Vendor Account
        User::create([
            'name' => 'vendor',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('vendorvendor'),
            'role' => 'vendor',
        ]);
    }
}
