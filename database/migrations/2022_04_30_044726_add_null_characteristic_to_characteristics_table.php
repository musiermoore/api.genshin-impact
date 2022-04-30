<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullCharacteristicToCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $characteristicType = \App\Models\CharacteristicType::query()
            ->where('slug', \App\Models\CharacteristicType::BASIC)
            ->first();

        \App\Models\Characteristic::query()
            ->create([
                'characteristic_type_id' => $characteristicType['id'],
                'name' => 'Отсутсвует',
                'slug' => 'none',
                'in_percent' => 0,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characteristics', function (Blueprint $table) {
            //
        });
    }
}
