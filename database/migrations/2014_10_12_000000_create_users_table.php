<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('external_id')->unique();
            $table->decimal('balance', 8, 2);
            $table->timestamps();
        });

        Schema::create('operations', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->integer('user_id', false, true);
            $blueprint->decimal('operation_costs', 8, 2);
            $blueprint->string('operation_status')->nullable(); // possible: hold, accepted, refused
            $blueprint->foreign('user_id')->references('id')->on('users');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
        Schema::dropIfExists('users');
    }
}
