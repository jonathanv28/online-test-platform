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
            'title' => 'Mathematics Test I',
            'code' => '744E80F',
            'image' => 'tests/mathematics.jpg',
            'duration' => '30'
        ]);
        
        Test::create([
            'title' => 'Physics Test II',
            'code' => '14EL20S',
            'image' => 'tests/physics.jpg',
            'duration' => '25'
        ]);

        Test::create([
            'title' => 'Biology Test I',
            'code' => 'JI250HV',
            'image' => 'tests/biology.jpg',
            'duration' => '20'
        ]);

        Test::create([
            'title' => 'Chemics Test III',
            'code' => '14T8AM2',
            'image' => 'tests/chemics.jpg',
            'duration' => '30'
        ]);
    }
}