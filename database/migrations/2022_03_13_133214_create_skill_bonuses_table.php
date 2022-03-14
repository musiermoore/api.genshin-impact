<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_bonuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('skill_id');

            $table->text('bonus');
            $table->foreignId('characteristic_id')->nullable();
            $table->boolean('add_bonus_to_character_characteristics')->default(0);

            $table->timestamps();

            $table->foreign('skill_id')->references('id')->on('skills');
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
        Schema::dropIfExists('skill_bonuses');
    }
}
