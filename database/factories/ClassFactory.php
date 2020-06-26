<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ScClass;
use Faker\Generator as Faker;

$factory->define(ScClass::class, function (Faker $faker) {
    return [
        'sc_school_id' => '1',
        'name' => $faker->name
    ];
});
