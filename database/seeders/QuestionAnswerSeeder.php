<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class QuestionAnswerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        DB::transaction(function () use ($faker) {

            for ($i = 1; $i <= 25; $i++) {

                $question = Question::create([
                    'question'   => rtrim($faker->sentence(rand(6, 10)), '.') . '?',
                    'marks'      => 1,
                    'status'     => 1,
                    'created_by' => 1,
                ]);

                // Pick 1 correct option randomly
                $correctIndex = rand(0, 3);

                for ($j = 0; $j < 4; $j++) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer'      => $faker->sentence(3),
                        'is_correct'  => $j === $correctIndex,
                    ]);
                }
            }
        });
    }
}
