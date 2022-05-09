<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapon_characteristics', function (Blueprint $table) {
            $table->foreignId('weapon_id');
            $table->foreignId('level_id');
            $table->foreignId('ascension_id');

            $table->float('base_atk')->unsigned();
            $table->float('sub_stat')->unsigned();

            $table->foreign('weapon_id')
                ->references('id')
                ->on('weapons');
            $table->foreign('level_id')
                ->references('id')
                ->on('levels');
            $table->foreign('ascension_id')
                ->references('id')
                ->on('ascensions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weapon_characteristics');
    }
}
