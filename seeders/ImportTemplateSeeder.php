<?php namespace Djetson\Shop\Seeders;

use \October\Rain\Database\Updates\Seeder;

/**
 * Class OrderSeeder
 * @package Djetson\Shop\Seeders
 */
class ImportTemplateSeeder extends Seeder
{
    public function run()
    {
        $this->call('Djetson\Shop\Seeders\StatusSeeder');
        $this->call('Djetson\Shop\Seeders\PaymentMethodSeeder');
        $this->call('Djetson\Shop\Seeders\ShippingMethodSeeder');
    }
}