<?php namespace  Djetson\Shop\Providers;

use Faker\Generator as FakerGenerator;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EloquentFactory::class, function ($app){
            $faker = $app->make(FakerGenerator::class);
            $factories_path = plugins_path('djetson/shop/factories');
            return EloquentFactory::construct($faker, $factories_path);
        });
    }
}