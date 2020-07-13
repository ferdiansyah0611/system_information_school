<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScClassroomQuestFillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_classroom_quest_fills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_classroom_post_id')->unsigned();
            $table->longText('answer');
            $table->string('correct');
            $table->string('file_fills')->nullable();
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
        Schema::dropIfExists('sc_classroom_quest_fills');
    }
}
