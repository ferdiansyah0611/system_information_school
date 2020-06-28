<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScReportCardElementary extends Model
{
	protected $table = 'sc_report_card_elementaries';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'sc_study_id', 'kkm', 'score', 'status', 'predicate'
    ];
}
