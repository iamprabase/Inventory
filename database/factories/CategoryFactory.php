<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'status' => $faker->randomElement(array('Active', 'Inactive'), 1)
    ];
});
