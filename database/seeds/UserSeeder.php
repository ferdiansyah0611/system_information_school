<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=2; $i < 11; $i++) {
            \DB::table('users')->insert([
                'id' => $i,
                'sc_school_id' => '1',
                'name' => 'NameUsers',
                'email' => 'anonymous' . $i . '@gmail.com',
                'nisn' => rand(1000000, 10000000),
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'born' => '2020-09-20',
                'location' => 'indonesia',
                'avatar' => 'avatar-teacher-male.png',
                'languange' => 'en',
                'gender' => 'male',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
