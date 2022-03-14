<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_characteristics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('character_level_id');
            $table->foreignId('characteristic_id');

            $table->timestamps();

            $table->foreign('character_level_id')->references('id')->on('character_levels');
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
        Schema::dropIfExists('character_characteristics');
    }
}
