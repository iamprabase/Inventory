<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
      'name' => $faker->unique()->company,
      'email' => $faker->unique()->safeEmail,
      'phone_number' => $faker->unique()->e164PhoneNumber,
      'contact_person' => $faker->name,
      'street_address' => $faker->streetAddress,
      'city' => $faker->city,
      'state' => $faker->state,
      'country' => $faker->country,
      'status' => $faker->randomElement(array('Active', 'Inactive'), 1),
    ];
});
