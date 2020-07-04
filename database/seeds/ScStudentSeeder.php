<?php

use Illuminate\Database\Seeder;
use App\Models\ScStudent;
class ScStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScStudent::create([
            'user_id' => '4',
            'sc_school_id' => '1',
            'sc_class_id' => '1',
            'phone' => '5849384059',
            'father' => 'Father',
            'mother' => 'Mother',
            'work_father' => 'Bussiness',
            'work_mother' => 'Online Bussiness',
            'phone_father' => '2384958472',
            'phone_mother' => '3849503928',
            'generation' => '2021'
        ]);
        ScStudent::create([
        	'user_id' => '5',
        	'sc_school_id' => '2',
        	'sc_class_id' => '1',
        	'phone' => '012345678910',
        	'father' => 'Father',
        	'mother' => 'Mother',
        	'work_father' => 'Bussiness',
        	'work_mother' => 'Online Bussiness',
        	'phone_father' => '2486935284',
        	'phone_mother' => '1938583928',
        	'generation' => '2021'
        ]);
    }
}
