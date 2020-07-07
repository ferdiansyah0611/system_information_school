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
        \DB::table('users')->insert([
        	'id' => '2',
        	'sc_school_id' => '1',
        	'name' => 'Ferdiansyah',
        	'email' => 'anonymous@gmail.com',
        	'nisn' => '3478375929',
        	'password' => bcrypt('password'),
        	'role' => 'admin',
        	'born' => '2020-09-20',
        	'location' => 'indonesia',
        	'avatar' => 'avatar.png',
        	'languange' => 'en',
            'gender' => 'male',
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now()
        ]);
        \DB::table('users')->insert([
            'id' => '3',
            'sc_school_id' => '1',
            'name' => 'Taylor Otween',
            'email' => 'otwen@gmail.com',
            'nisn' => '2525525255',
            'password' => bcrypt('password'),
            'role' => 'teacher',
            'born' => '2020-09-21',
            'location' => 'indonesia',
            'avatar' => 'avatar.png',
            'languange' => 'en',
            'gender' => 'male',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        \DB::table('users')->insert([
            'id' => '4',
            'sc_school_id' => '1',
            'name' => 'Fadillah Muhammad',
            'email' => 'fadillah@gmail.com',
            'nisn' => '7563847263',
            'password' => bcrypt('password'),
            'role' => 'student',
            'born' => '2020-09-22',
            'location' => 'indonesia',
            'avatar' => 'avatar.png',
            'languange' => 'en',
            'gender' => 'male',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        \DB::table('users')->insert([
            'id' => '5',
            'sc_school_id' => '1',
            'name' => 'Fadillah',
            'email' => 'fadil@gmail.com',
            'nisn' => '3857284950',
            'password' => bcrypt('password'),
            'role' => 'student',
            'born' => '2020-09-22',
            'location' => 'indonesia',
            'avatar' => 'avatar.png',
            'languange' => 'en',
            'gender' => 'male',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
