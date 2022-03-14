<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('server_id');

            $table->string('nickname');
            $table->smallInteger('level')->unsigned();
            $table->smallInteger('world_level')->unsigned();
            $table->boolean('gender');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('server_id')->references('id')->on('servers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
