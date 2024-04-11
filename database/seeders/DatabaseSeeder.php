<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jonathan Victor Goklas',
            'email' => 'jonathanaibaho@gmail.com',
            'password' => Hash::make('jagdisbzkagd'),
            'idcard' => 'users/$2y$10$4PvPe5w7qiiClEd02jSRwen6xWnb9ciiII8qyQ9vbrtu1iF3NoEhS-idcard.jpg',
            'photo' => 'users/$2y$10$WTgkDbkOU8uUaFg2UbO1n.nPISZ9f.wga6CNuvs4uYYIhRCDQo.fK-photo.jpg',
            'phone' => '085924152111',
            'institute' => 'Universitas Padjadjaran',
        ]);
    }
}
