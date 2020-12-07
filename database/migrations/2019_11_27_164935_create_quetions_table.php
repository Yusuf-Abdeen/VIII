<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuetionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quetions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->enum('difficulty',['easy', 'hard']);
            $table->integer('time')->default(30);

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('chapter_id');

            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quetions');
    }
}
