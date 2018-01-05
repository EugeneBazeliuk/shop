<?php

/**
 * PropertyValue factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\PropertyValue', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Property value ###');

    return [
        // Base
        'value' => $name,
    ];
});
