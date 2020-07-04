<?php

use Illuminate\Database\Seeder;
use App\Models\ScReportCardSenior;
class ScReportCardSeniorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScReportCardSenior::create([
        	'sc_study_id' => '1',
        	'score' => '98',
        	'kkm_k3' => '75',
        	'kkm_k4' => '75',
        	'k3_ph' => '80',
        	'k3_pts' => '84',
        	'k4_pr' => '100',
        	'status' => 'Success',
        	'predicate' => 'A'
        ]);
    }
}
