<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScClassroomComment extends Model
{
    protected $table = 'sc_classroom_comment_privates';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_classroom_post_id', 'user_id', 'comment'
    ];
}
