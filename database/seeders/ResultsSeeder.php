<?php

namespace Database\Seeders;

use App\Models\Result;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Result::create([
            'user_id' => '2',
            'test_id' => '1',
            'score' => '100',
            'start_time' => '2024-07-03 13:05:02',
            'end_time' => '2024-07-03 13:08:05',
        ]);

        Result::create([
            'user_id' => '1',
            'test_id' => '1',
        ]);
    }
}
