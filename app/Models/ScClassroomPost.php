<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScClassroomPost extends Model
{
    protected $table = 'sc_classroom_posts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 'description', 'asset', 'type'
    ];
}
