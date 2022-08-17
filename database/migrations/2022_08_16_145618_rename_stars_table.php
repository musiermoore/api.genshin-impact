<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stars', function (Blueprint $table) {
            $table->dropIndex('stars_star_unique');
            $table->renameColumn('star', 'rarity');

            $table->rename('rarities');
        });

        Schema::table('rarities', function (Blueprint $table) {
            $table->unique('rarity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rarities', function (Blueprint $table) {
            $table->renameColumn('rarity', 'star');
            $table->dropIndex('rarities_rarity_unique');

            $table->rename('stars');
        });

        Schema::table('stars', function (Blueprint $table) {
            $table->unique('star');
        });
    }
}
