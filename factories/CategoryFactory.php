<?php

/**
 * Category factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Category', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Category ###');

    return [
        // Base
        'name' => $name,
        'slug' => str_slug($name),
        // Description
        'meta_title' => $faker->realText(255),
        'meta_keywords' => $faker->realText(255),
        'meta_description' => $faker->realText(255),
        'description' => $faker->realText(250, 2),
        // States
        'is_active' => $faker->boolean(80),
        'is_searchable' => $faker->boolean(70),
        // Image
        //'image' => $faker->image($dir = temp_path() . '/faker', $width = 640, $height = 480)
    ];
});