<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('reciver_status', [1,2,3,4])->default(1);
            $table->enum('difficulty',[1, 2]);
            $table->enum('challenge_type', [1,2]);
            $table->bigInteger('reciver_id');

            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('matrial_id');

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('matrial_id')->references('id')->on('matrials')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
}
