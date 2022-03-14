<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtifactSetBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifact_set_bonuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('artifact_set_id');
            $table->foreignId('characteristic_id');

            $table->smallInteger('piece');
            $table->float('bonus');
            $table->boolean('add_bonus_to_character_characteristics')->default(0);

            $table->timestamps();

            $table->foreign('artifact_set_id')->references('id')->on('artifact_sets');
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
        Schema::dropIfExists('artifact_set_bonuses');
    }
}
