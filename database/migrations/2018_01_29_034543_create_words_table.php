<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content')->nullable();
            $table->integer('count_letter')->nullable();
            $table->longText('synonym')->nullable();
            $table->integer('count_synonym')->nullable();
            $table->longText('antonym')->nullable();
            $table->integer('count_antonym')->nullable();
            $table->longText('suffix')->nullable();
            $table->integer('count_suffix')->nullable();
            $table->longText('prefix')->nullable();
            $table->integer('count_prefix')->nullable();
            $table->longText('word_type')->nullable();
            $table->integer('count_word_type')->nullable();
            $table->longText('definition')->nullable();
            $table->integer('count_definition')->nullable();
            $table->integer('total')->nullable();
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
        Schema::dropIfExists('words');
    }
}
