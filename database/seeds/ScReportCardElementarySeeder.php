<?php

use Illuminate\Database\Seeder;
use App\Models\ScReportCardElementary;
class ScReportCardElementarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScReportCardElementary::create([
        	'sc_study_id' => '2',
        	'kkm' => '70', 
        	'score' => '89',
        	'status' => 'Success',
        	'predicate' => 'B'
        ]);
    }
}
