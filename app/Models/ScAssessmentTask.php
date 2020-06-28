<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScAssessmentTask extends Model
{
    protected $table = 'sc_assessment_tasks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_student_id', 'title', 'description', 'score'
    ];
}
