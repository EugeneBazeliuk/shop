<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        // Create warehouses table
        Schema::create('djetshop_warehouses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            // States
            $table->boolean('is_active')->default(false);
            // Timestamps
            $table->timestamps();
        });

        // Create primary table product > warehouse
        Schema::create('djetshop_products_warehouses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('warehouse_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->primary(['product_id', 'warehouse_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_warehouses');
        Schema::dropIfExists('djetshop_products_warehouses');
    }
}