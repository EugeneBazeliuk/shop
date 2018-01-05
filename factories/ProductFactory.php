<?php

/**
 * Product factory
 * @var $factory \Illuminate\Database\Eloquent\Factory
 */
$factory->define('Djetson\Shop\Models\Product', function (Faker\Generator $faker) {

    $name = $faker->unique()->numerify('Product ###');

    return [
        // Base
        'name' => $name,
        'slug' => str_slug($name),
        'sku' => $faker->unique()->ean8,
        'isbn' => $faker->unique()->isbn13,
        'price' => $faker->randomNumber(2),
        // Sizes
        'package_width' => $faker->randomNumber(2),
        'package_height' => $faker->randomNumber(2),
        'package_depth' => $faker->randomNumber(2),
        'package_weight' => $faker->randomNumber(2),
        // Description
        'description' => $faker->realText(1000, 2),
        'meta_title' => $faker->realText(255),
        'meta_keywords' => $faker->realText(255),
        'meta_description' => $faker->realText(255),
        // States
        'is_active' => $faker->boolean(70),
        'is_searchable' => $faker->boolean(70),
        'is_unique_text' => $faker->boolean(30),
        // Image
        //'image' => $faker->image($dir = temp_path() . '/faker', $width = 640, $height = 480),
    ];
});