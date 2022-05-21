<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMainCharacteristicIdToSubStatIdInWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weapons', function (Blueprint $table) {
            $table->dropForeign('weapons_main_characteristic_id_foreign');
            $query = "ALTER TABLE `weapons`
                CHANGE COLUMN `main_characteristic_id` `sub_stat_id` BIGINT(20) UNSIGNED NOT NULL;";

            \Illuminate\Support\Facades\DB::statement($query);

            $table->foreign('sub_stat_id')
                ->references('id')
                ->on('characteristics');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weapons', function (Blueprint $table) {
            $table->dropForeign('weapons_sub_stat_id_foreign');
            $query = "ALTER TABLE `weapons`
                CHANGE COLUMN `sub_stat_id` `main_characteristic_id` BIGINT(20) UNSIGNED NOT NULL;";

            \Illuminate\Support\Facades\DB::statement($query);

            $table->foreign('main_characteristic_id')
                ->references('id')
                ->on('characteristics');
        });
    }
}
