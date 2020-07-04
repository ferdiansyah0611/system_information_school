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
        ScAssessmentTask::create([
        	'sc_student_id' => '1',
        	'title' => 'New Task',
        	'description' => 'Task is configuration to install linux',
        	'score' => '100'
        ]);
    }
}
