<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScAbsentStudent extends Model
{
    protected $table = 'sc_absent_students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_student_id', 'date', 'status', 'opinion'
    ];
}
