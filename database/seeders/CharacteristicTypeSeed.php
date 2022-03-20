<?php

namespace Database\Seeders;

use App\Models\CharacteristicType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CharacteristicTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type' => 'Базовые характеристики', 'slug' => 'basic'],
            ['type' => 'Второстепенные характеристики', 'slug' => 'secondary'],
            ['type' => 'Элементы', 'slug' => 'elements']
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        CharacteristicType::insert($data);
    }
}
