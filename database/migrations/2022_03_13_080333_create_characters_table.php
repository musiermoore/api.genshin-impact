<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('account_id');

            $table->foreignId('star_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->foreignId('element_id');
            $table->foreignId('weapon_type_id');

            $table->timestamps();

            $table->foreign('star_id')->references('id')->on('stars');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('element_id')->references('id')->on('elements');
            $table->foreign('weapon_type_id')->references('id')->on('weapon_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
