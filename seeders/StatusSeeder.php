<?php namespace Djetson\Shop\Seeders;

use \Djetson\Shop\Models\Status;
use \October\Rain\Database\Updates\Seeder;

/**
 * Class StatusSeeder
 * @package Djetson\Shop\Seeders
 */
class StatusSeeder extends Seeder
{
    public function run()
    {
        Status::create([
            'name' => 'Оформлен',
            'color' => '#f1c40f',
            'is_active' => true
        ]);

        Status::create([
            'name' => 'Оплачен',
            'color' => '#d35400',
            'is_active' => true
        ]);

        Status::create([
            'name' => 'Упакован',
            'color' => '#f39c12',
            'is_active' => true
        ]);

        Status::create([
            'name' => 'Отправлен',
            'color' => '#d35400',
            'is_active' => true
        ]);

        Status::create([
            'name' => 'Выполнен',
            'color' => '#2ecc71',
            'is_active' => true
        ]);

        Status::create([
            'name' => 'Отменён',
            'color' => '#e74c3c',
            'is_active' => true
        ]);

        Status::create([
            'name' => 'Возврат',
            'color' => '#8e44ad',
            'is_active' => true
        ]);
    }
}