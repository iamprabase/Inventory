<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'brand_id' => function(){
          return factory(App\Models\Brand::class)->create()->id;
        },
        'price' => $faker->randomFloat(2, 0, 200000),
        'description' => $faker->text(500),
        'stock' => $faker->randomElement(array('In-stock', 'Out of Stock'), 1),
    ];
});
