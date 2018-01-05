<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateShippingMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_shipping_methods', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('provider');
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->decimal('free_shipping_limit', 10, 2)->default(0.00);
            // State
            $table->boolean('is_allow_in_order')->default(0);
            $table->boolean('is_allow_free_shipping')->default(0);
            $table->boolean('is_active')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_shipping_methods');
    }
}