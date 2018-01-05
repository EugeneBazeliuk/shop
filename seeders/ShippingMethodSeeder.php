<?php namespace Djetson\Shop\Seeders;

use \Djetson\Shop\Models\ShippingMethod;
use \October\Rain\Database\Updates\Seeder;

/**
 * Class ShippingMethodSeeder
 * @package Djetson\Shop\Seeders
 */
class ShippingMethodSeeder extends Seeder
{
    public function run()
    {
        ShippingMethod::create([
            'name' => 'Новая почта',
            'provider' => 'novaposhta',
            'cost' => 45,
            'is_active' => true
        ]);
    }
}