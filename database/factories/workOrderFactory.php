<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\work_order;
use Faker\Generator as Faker;

$factory->define(work_order::class, function (Faker $faker) {
    return [
        'order_number' => $faker->unique()->numerify('########'),
        'client' => $faker->randomElement(['Fanatics', 'Under Armour', 'Nike', 'Puma']),
        'ship_date' => $faker->dateTimeBetween('now','+3 months'),
        'status' => 1
    ];
});
