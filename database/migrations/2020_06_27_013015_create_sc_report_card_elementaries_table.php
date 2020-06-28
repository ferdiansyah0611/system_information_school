<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScReportCardElementariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_report_card_elementaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_study_id')->unsigned();
            $table->integer('kkm');
            $table->integer('score');
            $table->string('status');
            $table->string('predicate');
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
        Schema::dropIfExists('sc_report_card_elementaries');
    }
}
