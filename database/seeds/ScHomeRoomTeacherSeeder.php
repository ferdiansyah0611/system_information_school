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
        for ($i=0; $i < 10; $i++) {
            ScHomeRoomTeacher::create([
            	'sc_teacher_id' => $i,
            	'sc_class_id' => $i,
            	'start_period' => '2020-08-01',
            	'end_period' => '2021-08-01',
            ]);
        }
    }
}
