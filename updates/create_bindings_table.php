<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBindingsTable extends Migration
{
    public function up()
    {
        // Create bindings table
        Schema::create('djetshop_bindings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            // Meta
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            // BelongTo BindingType
            $table->integer('type_id')->unsigned()->index()->nullable();
            // States
            $table->boolean('is_active')->default(0);
            $table->boolean('is_searchable')->default(0);
            // Timestamps
            $table->timestamps();
            // Soft Delete
            $table->softDeletes();
        });

        // Create binding types table
        Schema::create('djetshop_binding_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            // Timestamps
            $table->timestamps();
        });

        // Create primary table product > binding
        Schema::create('djetshop_products_bindings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('binding_id')->unsigned();
            $table->primary(['product_id', 'binding_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_bindings');
        Schema::dropIfExists('djetshop_binding_types');
        Schema::dropIfExists('djetshop_products_bindings');
    }
}