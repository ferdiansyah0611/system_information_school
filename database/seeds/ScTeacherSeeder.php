<?php

use Illuminate\Database\Seeder;
use App\Models\ScTeacher;
class ScTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScTeacher::create([
        	'user_id' => '3',
        	'sc_school_id' => '1',
        	'title' => 'S.kom',
        	'graduate' => 'University Oxford',
        ]);
    }
}
