<?php

/**
 * Order Status factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Status', function (Faker\Generator $faker) {
    return [
        'name' => $faker->numerify('Status ###'),
        'color' => $faker->hexcolor,
        'is_active' => $faker->boolean(60),
        'is_send_email' => false,
        'is_attach_invoice' => false,
    ];
});