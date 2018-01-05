<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderLogsTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_order_logs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id')->unsigned()->index()->nullable();
            $table->integer('author_id')->unsigned()->index()->nullable();
            $table->string('event')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_order_logs');
    }
}
