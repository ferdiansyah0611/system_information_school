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
        for ($i=1; $i < 11; $i++) {
            ScStudent::create([
                'user_id' => $i,
                'sc_school_id' => '1',
                'sc_class_id' => '1',
                'phone' => rand(1000000, 100000000),
                'father' => 'Father',
                'mother' => 'Mother',
                'work_father' => 'Bussiness',
                'work_mother' => 'Online Bussiness',
                'phone_father' => rand(1000000, 100000000),
                'phone_mother' => rand(1000000, 100000000),
                'generation' => '2021'
            ]);
        }
    }
}
