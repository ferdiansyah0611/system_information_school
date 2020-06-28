<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScTypeReportCard extends Model
{
    protected $table = 'sc_type_report_cards';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 'sc_home_room_teacher_id', 'sc_student_id', 'type', 'period', 'description',
    	'absent_broken', 'absent_permission', 'absent_without_explanation', 'personality_behavior',
    	'personality_diligence', 'personality_neatness'
    ];
}
