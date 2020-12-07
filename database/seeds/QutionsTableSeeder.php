<?php

use App\Chapter;
use Illuminate\Database\Seeder;
use App\Matrial;
use App\Quetion;

class QuetionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chapters = Chapter::all();
        foreach($chapters as $chapter) {
            Quetion::create([
                ''
            ]);
        }
        // factory(App\Quetion::class, 100)->create();
    }
}
