<?php namespace Djetson\Shop\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class ExtendUsersTable extends Migration
{
    private $fields = [
        'phone',
        'address',
        'zip',
        'state_id',
        'country_id',
        'is_tricky',
    ];

    public function up()
    {
        if (Schema::hasColumns('users', $this->fields)) {
            return;
        }

        Schema::table('users', function(Blueprint $table) {
            $table->string('phone', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('state_id', 100)->nullable();
            $table->string('country_id', 100)->nullable();
            $table->boolean('is_tricky')->default(0);
        });
    }

    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn($this->fields);
            });
        }
    }
}