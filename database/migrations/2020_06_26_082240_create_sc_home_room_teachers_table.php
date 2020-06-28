<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScHomeRoomTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_home_room_teachers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_teacher_id')->unsigned();
            $table->bigInteger('sc_class_id')->unsigned();
            $table->date('start_period');
            $table->date('end_period');
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
        Schema::dropIfExists('sc_home_room_teachers');
    }
}
