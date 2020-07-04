<?php

use Illuminate\Database\Seeder;
use App\Models\ScSchool;
class ScSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScSchool::create([
        	'user_id' => '2',
        	'name' => 'SMK Letris Indonesia 1',
        	'description' => 'SMK Letris Indonesia 1 is best senior high school in indonesia',
        	'type' => 'senior_high_school',
        ]);
        ScSchool::create([
            'user_id' => '2',
            'name' => 'SDN Jombang 4',
            'description' => 'SMK Letris Indonesia 1 is best senior high school in indonesia',
            'type' => 'elementary_high_school',
        ]);
    }
}
