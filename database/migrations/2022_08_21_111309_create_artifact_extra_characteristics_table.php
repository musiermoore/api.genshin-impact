<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtifactExtraCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifact_extra_characteristics', function (Blueprint $table) {
            $table->foreignId('characteristic_id');
            $table->foreignId('rarity_id');
            $table->smallInteger('tier')->unsigned();
            $table->double('value')->unsigned();

            $table->foreign('characteristic_id')
                ->references('id')
                ->on('characteristics')
                ->cascadeOnDelete();

            $table->foreign('rarity_id')
                ->references('id')
                ->on('rarities')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artifact_extra_characteristics');
    }
}
