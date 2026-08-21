<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('admin'),
        ]);
        User::create([
            'name' => 'User',
            'email' => 'User@gmail.com',
            'role' => 'user',
            'status' => 'active',
            'password' => Hash::make('user'),
        ]);
    }
}
