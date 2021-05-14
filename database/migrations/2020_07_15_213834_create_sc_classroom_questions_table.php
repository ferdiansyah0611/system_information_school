<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScClassroomQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_classroom_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_classroom_post_id')->unsigned();
            $table->bigInteger('sc_teacher_id')->unsigned();
            $table->bigInteger('sc_study_id')->unsigned();
            $table->longText('question');
            $table->longText('note');
            $table->string('max_question');
            $table->date('max_date');
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
        Schema::dropIfExists('sc_classroom_questions');
    }
}
