<?php namespace Djetson\Shop\Seeders;

use \Djetson\Shop\Models\PaymentMethod;
use \October\Rain\Database\Updates\Seeder;

/**
 * Class PaymentMethodSeeder
 * @package Djetson\Shop\Seeders
 */
class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Приватбанк',
            'provider' => 'privatbank',
            'cost' => 0,
            'is_active' => true
        ]);
    }
}