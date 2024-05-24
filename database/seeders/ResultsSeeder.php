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
            'user_id' => '1',
            'test_id' => '1',
            'score' => 89,
        ]);

        Result::create([
            'user_id' => '1',
            'test_id' => '2',
        ]);

        Result::create([
            'user_id' => '1',
            'test_id' => '3',
        ]);

        Result::create([
            'user_id' => '2',
            'test_id' => '1',
        ]);
    }
}
