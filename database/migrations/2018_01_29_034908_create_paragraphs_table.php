<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParagraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paragraphs', function (Blueprint $table) {
          $table->increments('id');
          $table->longText('title')->nullable();
          $table->longText('content')->nullable();
          $table->integer('count_letter')->nullable();
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
        Schema::dropIfExists('paragraphs');
    }
}
