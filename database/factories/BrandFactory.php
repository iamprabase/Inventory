<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'status' => $faker->randomElement(array('Active', 'Inactive'), 1)
    ];
});
