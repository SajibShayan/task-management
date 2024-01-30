<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'full_name' => 'user',
            'user_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('p@ssword10'),
            'status' => 'active',
        ]);
    
    }
}
