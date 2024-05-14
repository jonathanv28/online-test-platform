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
            'idcard' => 'https://online-test-bucket-fyp1.s3.ap-southeast-2.amazonaws.com/users/664115b616b29.jpg',
            'photo' => 'https://online-test-bucket-fyp1.s3.ap-southeast-2.amazonaws.com/users/664115b70c4b1.jpg',
            'phone' => '085924152111',
            'institute' => 'Universitas Padjadjaran',
        ]);
    }
}
