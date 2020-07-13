<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScClassroomQuestChoice extends Model
{
    protected $table = 'sc_classroom_quest_choices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_classroom_post_id', 'answer', 'select_a', 'select_b', 'select_c', 'select_d', 'select_e',
    	'file_choices'
    ];
}
