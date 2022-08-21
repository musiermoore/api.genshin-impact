<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtifactTypeCharacteristicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifact_type_characteristic', function (Blueprint $table) {
            $table->foreignId('artifact_type_id');
            $table->foreignId('characteristic_id');

            $table->foreign('artifact_type_id')->references('id')->on('artifact_types')->cascadeOnDelete();
            $table->foreign('characteristic_id')->references('id')->on('characteristics')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artifact_type_characteristic');
    }
}
