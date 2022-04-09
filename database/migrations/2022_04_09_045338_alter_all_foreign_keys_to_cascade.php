<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAllForeignKeysToCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('character_levels', function (Blueprint $table) {
            $table->dropForeign('character_levels_character_id_foreign');
            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->onDelete('cascade');
        });
        Schema::table('character_characteristics', function (Blueprint $table) {
            $table->dropForeign('character_characteristics_character_level_id_foreign');
            $table->foreign('character_level_id')
                ->references('id')
                ->on('character_levels')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('character_levels', function (Blueprint $table) {
            $table->dropForeign('character_levels_character_id_foreign');
            $table->foreign('character_id')
                ->references('id')
                ->on('characters');
        });
        Schema::table('character_characteristics', function (Blueprint $table) {
            $table->dropForeign('character_characteristics_character_level_id_foreign');
            $table->foreign('character_level_id')
                ->references('id')
                ->on('characters');
        });
    }
}
