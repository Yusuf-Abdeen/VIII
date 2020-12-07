<?php

use Illuminate\Database\Seeder;
use App\Matrial;

class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *se/Connection.php:459

  Please use the argument -v to see more details.
                                                                               
     * @return void
     */
    public function run()
    {
        $matrials = Matrial::all();
        foreach($matrials as $matrial) {
            $matrial->chapters()->createMany(
                factory(App\Chapter::class, 3)->make()->toArray()
            );
        }
        // factory(App\Chapter::class, 20)->create();
    }
}
