<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxLevelToAscensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ascensions', function (Blueprint $table) {
            $table->smallInteger('max_level')->after('ascension')->default(20);
        });

        $maxLevelsByAscension = [
            0 => 20,
            1 => 40,
            2 => 50,
            3 => 60,
            4 => 70,
            5 => 80,
            6 => 90,
        ];

        foreach ($maxLevelsByAscension as $ascension => $maxLevel) {
            \App\Models\Ascension::query()
                ->where('ascensions.ascension', '=', $ascension)
                ->update(['max_level' => $maxLevel]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ascensions', function (Blueprint $table) {
            $table->dropColumn('max_level');
        });
    }
}
