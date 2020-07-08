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
        for ($i=1; $i < 11; $i++) {
            ScReportCardSenior::create([
                'sc_study_id' => $i,
                'score' => '89',
                'kkm_k3' => '75',
                'kkm_k4' => '70',
                'k3_ph' => '80',
                'k3_pts' => '90',
                'k4_pr' => '100',
                'status' => 'success',
                'predicate' => 'A'
            ]);
        }
    }
}
