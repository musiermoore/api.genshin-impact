<?php

namespace Database\Seeders;

use App\Models\ImageType;
use Illuminate\Database\Seeder;

class ImageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'type' => 'Главное изображение',
                'slug' => 'main'
            ]
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $types);

        ImageType::insert($data);
    }
}
