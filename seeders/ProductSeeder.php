<?php namespace Djetson\Shop\Seeders;

use Djetson\Shop\Models\Binding;
use Djetson\Shop\Models\Category;
use Djetson\Shop\Models\Manufacturer;
use Djetson\Shop\Models\Product;
use Djetson\Shop\Models\Warehouse;
use \October\Rain\Database\Updates\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $binding = Binding::create([
            // Base
            'name' => 'Test Binding',
            'description' => 'Test description for binding',
            // Meta
            'meta_title' => 'Test binding Meta Title',
            'meta_keywords' => 'Test binding Meta Keyword',
            'meta_description' => 'Test binding Description',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);

        $category = Category::create([
            // Base
            'name' => 'Test Category',
            'description' => 'Test description for category',
            // Meta
            'meta_title' => 'Test category Meta Title',
            'meta_keywords' => 'Test category Meta Keyword',
            'meta_description' => 'Test category Description',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);

        $manufacturer = Manufacturer::create([
            // Base
            'name' => 'Test Manufacturer',
            'description' => 'Test description for manufacturer',
            // Meta
            'meta_title' => 'Test manufacturer Meta Title',
            'meta_keywords' => 'Test manufacturer Meta Keyword',
            'meta_description' => 'Test manufacturer Description',
            // States
            'is_active' => true,
            'is_searchable' => true,
        ]);

        $warehouse = Warehouse::create([
            // Base
            'name' => 'Test Warehouse',
            'description' => 'Test description for warehouse',
            // States
            'is_active' => true,
        ]);

        $product = Product::make([
            // Base
            'name' => 'Test Product',
            'sku' => '1234568',
            'isbn' => '1234567890',
            'price' => 100.00,
            'description' => 'Test description for product',
            // Meta
            'meta_title' => 'Test product Meta Title',
            'meta_keywords' => 'Test product Meta Keyword',
            'meta_description' => 'Test product Description',
            // Sizes
            'package_width' => 10.00,
            'package_height' => 11.00,
            'package_depth' => 12.00,
            'package_weight' => 13.00,
            // States
            'is_active' => true,
            'is_searchable' => true,
            'is_unique_text' => true,
        ]);

        $product->category = $category;
        $product->manufacturer = $manufacturer;

        $product->bindings = [$binding];
        $product->categories = [$category];

        $product->save();

        $product->warehouses()->attach($warehouse, ['quantity' => 10]);
    }
}