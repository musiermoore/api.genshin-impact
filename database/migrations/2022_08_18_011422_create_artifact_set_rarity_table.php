<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtifactSetRarityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifact_set_rarity', function (Blueprint $table) {
            $table->foreignId('artifact_set_id');
            $table->foreignId('rarity_id');

            $table->foreign('artifact_set_id')->references('id')->on('artifact_sets');
            $table->foreign('rarity_id')->references('id')->on('rarities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artifact_set_rarity');
    }
}
