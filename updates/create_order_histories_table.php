<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('djetson_shop_order_histories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type');
            // Base
            $table->string('type');
            $table->text('data')->nullable();
            // Relation
            $table->integer('order_id')->unsigned();
            $table->integer('user_id')->unsigned();
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetson_shop_order_histories');
    }
}
