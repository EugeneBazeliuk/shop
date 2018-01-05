<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateReservesTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_reserves', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('code');
            // Relations
            $table->integer('author_id')->unsigned()->index()->nullable();
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->integer('warehouse_id')->unsigned()->index()->nullable();
            // Base
            $table->integer('quantity')->nullable();
            // Timestamps
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('reserved_to');
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_reserves');
    }
}