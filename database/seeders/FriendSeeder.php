<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Friend; // Import Model Friend yang kamu buat

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Friend::create([
            'name' => 'Budi Santoso',
            'phone' => '08123456789',
            'birth_date' => '1998-08-15',
            'notes' => 'Suka kado buku',
        ]);

        Friend::create([
            'name' => 'Siti Rahma',
            'phone' => '08987654321',
            'birth_date' => '2000-08-20',
            'notes' => 'Suka warna biru',
        ]);

        Friend::create([
            'name' => 'Andi Pratama',
            'phone' => '08555555555',
            'birth_date' => '1999-12-01',
            'notes' => 'Suka kopi',
        ]);
    }
}