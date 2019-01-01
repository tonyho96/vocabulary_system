<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('timers', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users');
          $table->string('type')->nullable();
          $table->datetime('start')->nullable();
          $table->datetime('end')->nullable();
          $table->datetime('duration')->nullable();
          $table->integer('session_id')->unsigned();
          $table->foreign('session_id')->references('id')->on('sessions');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timers');
    }
}
