<?php

/**
 * PropertyGroup factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\PropertyGroup', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Property group ###');

    return [
        // Base
        'name' => $name,
    ];
});
