<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateManufacturersTable extends Migration
{
    public function up()
    {
        // Create manufactures table
        Schema::create('djetshop_manufacturers', function(Blueprint $table) {
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
            // States
            $table->boolean('is_active')->default(false);
            $table->boolean('is_searchable')->default(false);
            // Timestamps
            $table->timestamps();
            // Soft Delete
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_manufacturers');
    }
}