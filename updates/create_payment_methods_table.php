<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_payment_methods', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->string('name');
            $table->string('provider');
            $table->decimal('cost', 10, 2)->nullable();
            // State
            $table->boolean('is_active')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_payment_methods');
    }
}
