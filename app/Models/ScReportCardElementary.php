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
    	'id', 'sc_study_id', 'score', 'kkm_k3', 'kkm_k4', 'k3_ph', 'k3_pts', 'k4_pr',
    	'status', 'predicate'
    ];

}
