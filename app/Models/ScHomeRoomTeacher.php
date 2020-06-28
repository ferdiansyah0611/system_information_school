<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScHomeRoomTeacher extends Model
{
    protected $table = 'sc_home_room_teachers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_teacher_id', 'sc_class_id', 'start_period', 'end_period'
    ];
}