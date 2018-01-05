<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_orders', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            // Base
            $table->increments('id');
            $table->text('comment')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            // Totals
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('payment_total', 10, 2)->nullable();
            $table->decimal('shipping_total', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            // Customer
            $table->string('customer_name')->nullable();
            $table->string('customer_surname')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            // Shipping
            $table->string('zip')->nullable();
            $table->string('track')->nullable();
            $table->string('address')->nullable();
            // Relation
            $table->integer('state_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->index()->nullable();
            $table->integer('manager_id')->unsigned()->index()->nullable();
            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->integer('payment_method_id')->unsigned()->index()->nullable();
            $table->integer('shipping_method_id')->unsigned()->index()->nullable();
            // States
            $table->boolean('is_draft')->default(0);
            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_orders');
    }
}