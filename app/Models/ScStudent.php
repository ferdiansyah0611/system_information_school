<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScStudent extends Model
{
    protected $table = 'sc_students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sc_school_id', 'sc_class_id', 'phone', 'father', 'mother', 'work_father', 'work_mother', 'phone_father', 'phone_mother', 'generation'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}