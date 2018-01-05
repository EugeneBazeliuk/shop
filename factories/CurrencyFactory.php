<?php

/**
 * Currency factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Currency', function (Faker\Generator $faker) {
    return [
        'name' => $faker->numerify('Currency ###'),
        'code' => $faker->unique()->currencyCode,
        'symbol' => $faker->randomElement($array = array ('$','#','&')),
        'position' => $faker->randomElement($array = array ('after','before')),
        'space' => $faker->boolean(50),
    ];
});