<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::create([
            'test_id' => '1',
            'question_text' => 'What is 2 + 3?',
            'correct_answer' => '2'
        ]);

        Question::create([
            'test_id' => '1',
            'question_text' => 'What is 3 + 5?',
            'correct_answer' => '3'
        ]);

        Question::create([
            'test_id' => '1',
            'question_text' => 'What is 5 + 2?',
            'correct_answer' => '1'
        ]);

        Question::create([
            'test_id' => '2',
            'question_text' => 'What is 2 + 3?',
            'correct_answer' => '2'
        ]);

        Question::create([
            'test_id' => '2',
            'question_text' => 'What is 3 + 5?',
            'correct_answer' => '3'
        ]);

        Question::create([
            'test_id' => '2',
            'question_text' => 'What is 5 + 2?',
            'correct_answer' => '1'
        ]);
    }
}
