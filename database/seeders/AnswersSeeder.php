<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Answer::create([
            'question_id' => '1',
            'option_text' => '3',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => '4',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => '5',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => '6',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '5',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '6',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '7',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '8',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '6',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '7',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '8',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '9',
            'is_correct' => '0'
        ]);
    }
}
