<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateImportTasksTable extends Migration
{
    public function up()
    {
        Schema::create('djetshop_import_tasks', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('template_id')->unsigned()->index()->nullable();
            $table->integer('progress')->nullable();
            $table->string('status')->nullable();
            $table->text('details')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('djetshop_import_tasks');
    }
}
