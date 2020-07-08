<?php

use Illuminate\Database\Seeder;
use App\Models\ScAssessmentTask;
class ScAssessmentTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) {
            ScAssessmentTask::create([
            	'sc_student_id' => $i,
            	'title' => 'New Task ' . $i,
            	'description' => 'Task is configuration to install linux',
            	'score' => '100'
            ]);
        }
    }
}
