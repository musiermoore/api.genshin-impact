<?php

namespace Database\Seeders;

use App\Models\Ascension;
use Illuminate\Database\Seeder;

class AscensionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['ascension' => 0],
            ['ascension' => 1],
            ['ascension' => 2],
            ['ascension' => 3],
            ['ascension' => 4],
            ['ascension' => 5],
            ['ascension' => 6]
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        Ascension::insert($data);
    }
}
