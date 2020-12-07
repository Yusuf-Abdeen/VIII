<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sender_correct_answers')->default(0);
            $table->integer('sender_wrong_answers')->default(0);
            $table->integer('reciver_correct_answers')->default(0);
            $table->integer('reciver_wrong_answers')->default(0);
            $table->integer('winner_id')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('challenge_id');

            $table->foreign('challenge_id')->references('id')->on('challenges')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge_statistics');
    }
}
