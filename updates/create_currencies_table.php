<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCurrenciesTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_currencies', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('symbol')->nullable();
            $table->string('position')->nullable();
            $table->boolean('space')->default(false);
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_currencies');
    }
}