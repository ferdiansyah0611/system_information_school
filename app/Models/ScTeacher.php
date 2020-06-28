<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScTeacher extends Model
{
    protected $table = 'sc_teachers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'sc_school_id', 'title', 'graduate'
    ];
}
