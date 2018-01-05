<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateWarehouseLogsTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_warehouse_logs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('event')->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            // Relations
            $table->integer('author_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->integer('warehouse_id')->unsigned()->index();
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_warehouse_logs');
    }
}
