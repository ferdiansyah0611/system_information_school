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
        for ($i=1; $i < 11; $i++) {
            ScSchool::create([
            	'user_id' => '2',
            	'name' => 'SMK ' . $i,
            	'description' => 'SMK ' . $i . ' is best senior high school in indonesia',
            	'type' => 'senior_high_school',
            ]);
            ScSchool::create([
                'user_id' => '2',
                'name' => 'SMP ' . $i,
                'description' => 'SMP ' . $i . ' is best junior high school in indonesia',
                'type' => 'junior_high_school',
            ]);
            ScSchool::create([
                'user_id' => '2',
                'name' => 'SDN ' . $i,
                'description' => 'SDN ' . $i . ' is best elementary high school in indonesia',
                'type' => 'elementary_high_school',
            ]);
        }
    }
}
