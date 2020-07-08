<?php

use Illuminate\Database\Seeder;
use App\Models\ScTypeReportCard;
class ScTypeReportCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 11; $i++) { 
            ScTypeReportCard::create([
            	'sc_home_room_teacher_id' => '1',
            	'sc_student_id' =>  $i,
            	'type' => 'senior_high_school',
            	'period' => '2020-07-02',
            	'description' => 'Description',
            	'absent_broken' => '0',
            	'absent_permission' => '0',
            	'absent_without_explanation' => '0',
            	'personality_behavior' => '99',
            	'personality_diligence' => '100',
            	'personality_neatness' => '89'
            ]);
        }
    }
}
