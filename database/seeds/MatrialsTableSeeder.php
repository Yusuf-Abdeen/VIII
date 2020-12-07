<?php

use Illuminate\Database\Seeder;

class MatrialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Matrial::class, 5)->create();
    }
}
