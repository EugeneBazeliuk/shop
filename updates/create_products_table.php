<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('isbn')->unique()->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->text('description')->nullable();
            // Meta
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            // Sizes
            $table->double('package_width', 10, 2)->nullable();
            $table->double('package_height', 10, 2)->nullable();
            $table->double('package_depth', 10, 2)->nullable();
            $table->double('package_weight', 10, 2)->nullable();
            // Relations
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->integer('manufacturer_id')->unsigned()->index()->nullable();
            // States
            $table->boolean('is_active')->default(0);
            $table->boolean('is_searchable')->default(0);
            $table->boolean('is_unique_text')->default(0);
            // Timestamps
            $table->timestamps();
            // Soft Delete
            $table->softDeletes();
        });

        // Create primary table product > featured
        Schema::create('djetshop_products_featured', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('featured_id')->unsigned();
            $table->primary(['product_id', 'featured_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_products');
        Schema::dropIfExists('djetshop_products_featured');
    }
}