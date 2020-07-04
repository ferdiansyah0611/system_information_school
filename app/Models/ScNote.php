<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ScNote extends Model
{
    protected $table = 'sc_notes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 'title', 'note'
    ];
}
