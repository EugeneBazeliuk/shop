<?php namespace Djetson\Shop\Seeders;

use \Djetson\Shop\Models\ImportTemplate;
use \October\Rain\Database\Updates\Seeder;

/**
 * Class OrderSeeder
 * @package Djetson\Shop\Seeders
 */
class OrderSeeder extends Seeder
{
    public function run()
    {
        ImportTemplate::create([
            'name' => 'Тестовый шаблон импорта',
            'mapping' => [
                [ 'key' => 'Name', 'column' => 'name'],
                [ 'key' => 'isbn', 'column' => 'isbn'],
                [ 'key' => 'Article', 'column' => 'sku'],
                [ 'key' => 'Cost', 'column' => 'price'],
                [ 'key' => 'comment', 'column' => 'description'],
                [ 'key' => 'NamePublisher', 'column' => 'manufacturer'],
                [ 'key' => 'NameGrpL1', 'column' => 'categories'],
                [ 'key' => 'NameGrpL2', 'column' => 'categories'],
                [ 'key' => 'NameGrpL3', 'column' => 'categories'],
                [ 'key' => 'author', 'column' => 'bindings'],
                [ 'key' => 'NameSeria', 'column' => 'bindings'],
                [ 'key' => 'Translater', 'column' => 'bindings'],
                [ 'key' => 'Editor', 'column' => 'bindings'],
                [ 'key' => 'pagecount', 'column' => 'properties'],
                [ 'key' => 'NameCover', 'column' => 'properties'],
                [ 'key' => 'NameFormatBook', 'column' => 'properties'],
            ],
            'is_active' => true
        ]);
    }
}