<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScStudy extends Model
{
    protected $table = 'sc_studies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sc_school_id', 'sc_class_id', 'sc_teacher_id', 'name', 'day', 'time'
    ];
}
