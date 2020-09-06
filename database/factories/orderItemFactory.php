<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\order_item;
use Faker\Generator as Faker;

$factory->define(order_item::class, function (Faker $faker) use ($factory) {
    return [
            'style'=> $faker->numerify('######'),
            'color'=> $faker->randomElement(['Black', 'White', 'Red', 'Blue','Green','Yellow']),
            'ship_info' => $faker->address,
            'fob_price'=> $faker->numerify('#.##'),
            'work_order_id' => $factory->create(App\work_order::class)->id
    ];
});
