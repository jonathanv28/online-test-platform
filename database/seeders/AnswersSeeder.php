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
            'option_text' => 'A. 3',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => 'B. 4',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => 'C. 5',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => 'D. 6',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => 'A. 5',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => 'B. 6',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => 'C. 7',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => 'D. 8',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => 'A. 6',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => 'B. 7',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => 'C. 8',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => 'D. 9',
            'is_correct' => '0'
        ]);
    }
}
