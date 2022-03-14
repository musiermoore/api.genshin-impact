<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_levels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('character_id');
            $table->foreignId('level_id');
            $table->foreignId('ascension_id');

            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('ascension_id')->references('id')->on('ascension');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_levels');
    }
}
