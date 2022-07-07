<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArtifactTypeIdToArtifactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artifacts', function (Blueprint $table) {
            $table->foreignId('artifact_type_id')->after('artifact_set_id');
            $table->foreign('artifact_type_id')->references('id')->on('artifact_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artifacts', function (Blueprint $table) {
            $table->dropForeign('artifacts_artifact_type_id_foreign');
            $table->dropColumn('artifact_type_id');
        });
    }
}
