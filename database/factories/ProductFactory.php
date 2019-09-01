<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'sku'          => $faker->uuid,
        'slug'         => $faker->unique()->slug,
        'name'         => $faker->city,
        'photo'        => 'default.png',
        'description'  => $faker->text($maxNbChars = 100),
        'price'        => $faker->randomFloat(2, 1, 10),
        'stock'        => $faker->randomNumber(3),
        'is_active'    => true,
    ];
});
