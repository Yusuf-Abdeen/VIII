<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('wrong_answers');
            $table->integer('correct_answers');
            $table->enum('stars', [1, 2, 3]);

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('matrial_id');
            $table->unsignedBigInteger('chapter_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('matrial_id')->references('id')->on('matrials')->onDelete('CASCADE');
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
        Schema::dropIfExists('test_statements');
    }
}
