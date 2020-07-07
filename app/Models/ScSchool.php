<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScSchool extends Model
{
    protected $table = 'sc_schools';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'name', 'description', 'type'
    ];
}
