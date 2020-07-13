<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScClassroomQuestFill extends Model
{
    protected $table = 'sc_classroom_quest_fills';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_classroom_post_id', 'answer', 'file_fills'
    ];
}
