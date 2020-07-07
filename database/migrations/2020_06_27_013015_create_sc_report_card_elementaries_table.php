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
            $table->integer('score');
            $table->integer('kkm_k3');
            $table->integer('kkm_k4');
            $table->integer('k3_ph');//penilaian harian
            $table->integer('k3_pts');//pts
            $table->integer('k4_pr');
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
