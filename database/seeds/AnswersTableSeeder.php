<?php

use App\Quetion;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quetions = Quetion::all();
        foreach($quetions as $quetion) {
            $quetion->answers()->createMany(
                factory(App\Answer::class, 5)->make()->toArray()
            );
        }
        // factory(App\Answer::class, 5)->create();
    }
}
