<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStarIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign('characters_star_id_foreign');
            $table->dropIndex('characters_star_id_foreign');
            $table->renameColumn('star_id', 'rarity_id');
            $table->foreign('rarity_id')->references('id')->on('rarities');
        });

        Schema::table('weapons', function (Blueprint $table) {
            $table->dropForeign('weapons_star_id_foreign');
            $table->dropIndex('weapons_star_id_foreign');
            $table->renameColumn('star_id', 'rarity_id');
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
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign('characters_rarity_id_foreign');
            $table->dropIndex('characters_rarity_id_foreign');
            $table->renameColumn('rarity_id', 'star_id');
            $table->foreign('star_id')->references('id')->on('rarities');
        });

        Schema::table('weapons', function (Blueprint $table) {
            $table->dropForeign('weapons_rarity_id_foreign');
            $table->dropIndex('weapons_rarity_id_foreign');
            $table->renameColumn('rarity_id', 'star_id');
            $table->foreign('star_id')->references('id')->on('rarities');
        });
    }
}
