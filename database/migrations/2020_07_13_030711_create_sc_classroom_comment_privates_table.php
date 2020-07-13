<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScClassroomCommentPrivatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_classroom_comment_privates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sc_classroom_post_id')->unsigned();
            $table->bigInteger('user_id');
            $table->string('comment');
            $table->string('file_comment');
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
        Schema::dropIfExists('sc_classroom_comment_privates');
    }
}
