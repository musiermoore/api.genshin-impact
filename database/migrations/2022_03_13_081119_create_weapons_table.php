<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('weapon_type_id');
            $table->foreignId('star_id');

            $table->string('name')->unique();
            $table->foreignId('main_characteristic_id');
            $table->text('description');

            $table->timestamps();

            $table->foreign('weapon_type_id')->references('id')->on('weapon_types');
            $table->foreign('star_id')->references('id')->on('stars');
            $table->foreign('main_characteristic_id')->references('id')->on('characteristics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weapons');
    }
}
