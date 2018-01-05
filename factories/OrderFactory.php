<?php

/**
 * Order Item factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Order', function (Faker\Generator $faker) {
    return [
        'comment' => $faker->text(200),
        'phone' => $faker->phoneNumber,
        'track' => $faker->isbn13,
        'shipping_address' => [
            'firstname' => $faker->name,
            'lastname' => $faker->lastName,
            'address' => $faker->address,
            'city' => $faker->city,
        ],
        'billing_address' => [
            'firstname' => $faker->name,
            'lastname' => $faker->lastName,
            'address' => $faker->address,
            'city' => $faker->city,
        ],
        'is_billing_as_shipping' => false,
    ];
});