<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_studies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_school_id');
            $table->bigInteger('sc_class_id');
            $table->bigInteger('sc_teacher_id');
            $table->string('name');
            $table->string('day');
            $table->string('time');
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
        Schema::dropIfExists('sc_studies');
    }
}
