<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScAlumniStudent extends Model
{
    protected $table = 'sc_alumni_students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_student_id', 'student_id_number', 'work'
    ];
}
