<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapon_bonuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('weapon_id');
            $table->foreignId('characteristic_id');
            $table->float('value');

            $table->timestamps();

            $table->foreign('weapon_id')->references('id')->on('weapons');
            $table->foreign('characteristic_id')->references('id')->on('characteristics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weapon_bonuses');
    }
}
