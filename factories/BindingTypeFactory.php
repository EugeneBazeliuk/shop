<?php

/**
 * BindingType factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\BindingType', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('BindingType ###');

    return [
        // base
        'name' => $name,
        'code' => str_slug($name),
    ];
});