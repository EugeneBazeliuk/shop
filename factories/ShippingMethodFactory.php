<?php

/**
 * Shipping Method factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\ShippingMethod', function (Faker\Generator $faker) {
    return [
        'name' => $faker->numerify('Shipping method ###'),
        'provider' => $faker->randomElement(['self','novaposhta', 'ukrposhta']),
        'cost' => $faker->randomNumber(2),
        'free_shipping_limit' => $faker->randomNumber(3),
        'is_allow_in_order' => $faker->boolean(50),
        'is_allow_free_shipping' => $faker->boolean(50),
        'is_active' => $faker->boolean(50),
    ];
});