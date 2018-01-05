<?php

/**
 * Order Status factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Warehouse', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Warehouse ###');

    return [
        // Base
        'name' => $name,
        'code' => str_slug($name),
        'description' => $faker->realText(250, 2),
        // States
        'is_active' => $faker->boolean(80),
    ];
});