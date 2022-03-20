<?php

namespace Database\Seeders;

use App\Models\Star;
use Illuminate\Database\Seeder;

class StarSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['star' => 1],
            ['star' => 2],
            ['star' => 3],
            ['star' => 4],
            ['star' => 5]
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        Star::insert($data);
    }
}
