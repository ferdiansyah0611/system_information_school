<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ScStudent;
use Faker\Generator as Faker;

$factory->define(ScStudent::class, function (Faker $faker) {
    return [
    	'user_id' => rand(1000, 20000),
        'sc_school_id' => '1',
        'sc_class_id' => '1',
        'phone' => rand(10000000000, 100000000000),
        'father' => $faker->name,
        'mother' => $faker->name,
        'work_father' => 'Bussiness',
        'work_mother' => 'Bussiness',
        'phone_father' => rand(10000000000, 100000000000),
        'phone_mother' => rand(10000000000, 100000000000),
        'generation' => '2019/2020'
    ];
});
