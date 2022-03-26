<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characteristics', function (Blueprint $table) {
            $table->dropForeign('characteristics_characteristic_id_foreign');
            $table->dropColumn('characteristic_id');

            $table->foreignId('characteristic_type_id')->after('id');
            $table->foreign('characteristic_type_id')->references('id')->on('characteristic_types');

            $table->boolean('in_percent')->after('slug')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characteristics', function (Blueprint $table) {
            $table->dropForeign('characteristics_characteristic_type_id_foreign');
            $table->dropColumn('characteristic_type_id');

            $table->foreignId('characteristic_id')->after('id');
            $table->foreign('characteristic_id')->references('id')->on('characteristics');

            $table->dropColumn('in_percent');
        });
    }
}
