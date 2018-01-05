<?php

/**
 * Binding factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Binding', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Binding ###');

    return [
        // base
        'name' => $name,
        'slug' => str_slug($name),
        // description
        'meta_title' => $faker->realText(255),
        'meta_keywords' => $faker->realText(255),
        'meta_description' => $faker->realText(255),
        'description' => $faker->realText(250, 2),
        // states
        'is_active' => $faker->boolean(80),
        'is_searchable' => $faker->boolean(70),
    ];
});