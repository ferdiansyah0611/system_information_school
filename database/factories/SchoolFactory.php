<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ScSchool;
use Faker\Generator as Faker;

$factory->define(ScSchool::class, function (Faker $faker) {
    return [
        'user_id' => '1',
        'name' => $faker->name . '_' . rand(1000,10000),
        'description' => 'This description table'
    ];
});
