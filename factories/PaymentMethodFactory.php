<?php

/**
 * Payment Method factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\PaymentMethod', function (Faker\Generator $faker) {
    return [
        'name' => $faker->numerify('Payment method ###'),
        'provider' => 'test_provider',
        'cost' => $faker->randomNumber(2),
        'is_active' => $faker->boolean(50),
    ];
});