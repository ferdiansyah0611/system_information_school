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
        for ($i=1; $i < 11; $i++) {
            ScTeacher::create([
            	'user_id' => $i,
            	'sc_school_id' => '1',
            	'title' => 'S.kom',
            	'graduate' => 'University Oxford',
            ]);
        }
    }
}
