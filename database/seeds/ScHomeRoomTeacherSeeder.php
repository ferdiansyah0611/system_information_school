<?php

use Illuminate\Database\Seeder;
use App\Models\ScHomeRoomTeacher;
class ScHomeRoomTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScHomeRoomTeacher::create([
        	'sc_teacher_id' => '1',
        	'sc_class_id' => '1',
        	'start_period' => '2020-08-01',
        	'end_period' => '2021-08-01',
        ]);
    }
}
