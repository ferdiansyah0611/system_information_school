<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScClassroomQuestion extends Model
{
	protected $table = 'sc_classroom_questions';
    protected $fillable = [
    	'sc_classroom_post_id', 'sc_teacher_id', 'sc_study_id', 'question', 'max_question', 'max_date', 'note'
    ];
}
