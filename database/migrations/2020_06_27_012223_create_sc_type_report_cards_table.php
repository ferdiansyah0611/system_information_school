<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScTypeReportCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_type_report_cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_home_room_teacher_id')->unsigned();
            $table->bigInteger('sc_student_id')->unsigned();
            $table->string('type');/*semester 1 2 ganjil/genap */
            $table->date('period');
            $table->longText('description');
            $table->integer('absent_broken');
            $table->integer('absent_permission');
            $table->integer('absent_without_explanation');
            $table->integer('personality_behavior');//kelakuan
            $table->integer('personality_diligence');//kerajinana
            $table->integer('personality_neatness');//kerapihan
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
        Schema::dropIfExists('sc_type_report_cards');
    }
}
