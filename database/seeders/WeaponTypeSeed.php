<?php

namespace Database\Seeders;

use App\Models\WeaponType;
use Illuminate\Database\Seeder;

class WeaponTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type' => 'Лук', 'slug' => 'bow'],
            ['type' => 'Одноручный меч', 'slug' => 'sword'],
            ['type' => 'Двуручный меч', 'slug' => 'claymore'],
            ['type' => 'Копье', 'slug' => 'polearm'],
            ['type' => 'Катализатор', 'slug' => 'catalyst'],
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        WeaponType::insert($data);
    }
}
