<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtifactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artifacts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('artifact_set_id');
            $table->foreignId('star_id');

            $table->string('name');

            $table->timestamps();

            $table->foreign('artifact_set_id')->references('id')->on('artifact_sets');
            $table->foreign('star_id')->references('id')->on('stars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artifacts');
    }
}
