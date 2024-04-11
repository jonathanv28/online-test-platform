<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Test::create([
            'title' => 'Mathematics Quiz',
            'code' => '744E80F',
            'image' => 'tests/mathematics.jpg',
            'duration' => '20'
        ]);
    }
}