<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('character_id');
            $table->foreignId('skill_type_id');

            $table->string('name');
            $table->string('slug');

            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('skill_type_id')->references('id')->on('skill_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
    }
}
