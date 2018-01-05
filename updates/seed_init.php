<?php namespace Djetson\Shop\Updates;

use App;
use Djetson\Shop\Models\Currency;
use Djetson\Shop\Models\Settings;
use \October\Rain\Database\Updates\Seeder;

/**
 * Class SeedInitial
 * @package Djetson\Shop\Updates
 */
class SeedInitial extends Seeder
{
    public function run()
    {
        // Create Currency
        $currency = Currency::create([
            'name' => 'Гривна',
            'code' => 'GRN',
            'symbol' => 'грн.',
            'position' => 'after',
            'space' => true,
        ]);

        // Set default settings
        $settings = Settings::instance();
        $settings->currency = $currency;
        $settings->save();

        if (!App::environment('testing')) {
            $this->call('Djetson\Shop\Seeders\ProductSeeder');
            $this->call('Djetson\Shop\Seeders\OrderSeeder');
            $this->call('Djetson\Shop\Seeders\ImportTemplateSeeder');
        }
    }
}