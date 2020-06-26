<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique();
            $table->bigInteger('sc_school_id')->unsigned();
            $table->bigInteger('sc_class_id')->unsigned();
            $table->bigInteger('phone')->unique();
            $table->string('father');
            $table->string('mother');
            $table->bigInteger('phone_father');
            $table->bigInteger('phone_mother');
            $table->string('generation');
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
        Schema::dropIfExists('sc_students');
    }
}
