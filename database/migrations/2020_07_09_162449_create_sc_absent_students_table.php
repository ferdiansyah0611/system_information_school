<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScAbsentStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_absent_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_student_id')->unsigned();
            $table->date('date')->unique();
            $table->string('status');
            $table->string('opinion')->nullable();
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
        Schema::dropIfExists('sc_absent_students');
    }
}
