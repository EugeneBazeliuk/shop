<?php

/**
 * Property factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Property', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Property ###');

    return [
        // Base
        'name' => $name,
        'code' => str_slug($name),
        // Description
        'description' => $faker->realText(255),
        // States
        'is_active' => $faker->boolean(70),
    ];
});
