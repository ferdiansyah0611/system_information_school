<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScClass extends Model
{
    protected $table = 'sc_classes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'sc_school_id', 'name'
    ];
}