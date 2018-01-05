<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_order_statuses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Base
            $table->integer('order_id')->unsigned()->index()->nullable();
            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->text('comment')->nullable();
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_order_statuses');
    }
}