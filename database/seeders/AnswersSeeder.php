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
            'option_text' => '120 pages',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => '580 pages',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => '610 pages',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '1',
            'option_text' => '700 pages',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '10x^2 + 6y^4',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '10x^2 - 6y^4',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '25x^2 - 6y^4',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '2',
            'option_text' => '25x^2 - 9y^4',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '-64/7',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '64/7',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '-34/7',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '3',
            'option_text' => '34/7',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '4',
            'option_text' => '$394.25',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '4',
            'option_text' => '$408.50',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '4',
            'option_text' => '$422.75',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '4',
            'option_text' => '$422.00',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '5',
            'option_text' => '$6.50',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '5',
            'option_text' => '$10.50',
            'is_correct' => '1'
        ]);

        Answer::create([
            'question_id' => '5',
            'option_text' => '$12.00',
            'is_correct' => '0'
        ]);

        Answer::create([
            'question_id' => '5',
            'option_text' => '$6.00',
            'is_correct' => '0'
        ]);
    }
}
