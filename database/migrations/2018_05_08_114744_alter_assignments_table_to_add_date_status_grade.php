<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAssignmentsTableToAddDateStatusGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignment', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->string('status')->nullable();
            $table->string('update_status')->nullable();
            $table->integer('grade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignment', function (Blueprint $table) {
            //
        });
    }
}
