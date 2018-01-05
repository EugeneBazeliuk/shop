<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        // Create properties table
        Schema::create('djetshop_properties', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            // BelongTo PropertyGroup
            $table->integer('group_id')->unsigned()->index()->nullable();
            // Sortable
            $table->integer('sort_order')->default(0);
            // States
            $table->boolean('is_active')->default(false);
        });

        // Create property groups table
        Schema::create('djetshop_property_groups', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            // Sortable
            $table->integer('sort_order')->default(0);
        });

        // Create property values table
        Schema::create('djetshop_property_values', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('value');
            // BelongTo Property
            $table->integer('property_id')->unsigned()->index()->nullable();
        });

        // Create primary table product > property
        Schema::create('djetshop_products_properties', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->integer('property_value_id')->unsigned()->index()->nullable();
            $table->primary(['product_id', 'property_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_properties');
        Schema::dropIfExists('djetshop_property_groups');
        Schema::dropIfExists('djetshop_property_values');
        Schema::dropIfExists('djetshop_products_properties');
    }
}