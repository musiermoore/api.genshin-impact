<?php

namespace Database\Seeders;

use App\Models\ArtifactType;
use Illuminate\Database\Seeder;

class ArtifactTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type' => 'Цветок жизни', 'slug' => 'flower-of-life'],
            ['type' => 'Перо смерти', 'slug' => 'plume-of-death'],
            ['type' => 'Пески времени', 'slug' => 'sands-of-eon'],
            ['type' => 'Кубок пространства', 'slug' => 'goblet-of-eonothem'],
            ['type' => 'Корона разума', 'slug' => 'circlet-of-logos'],
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        ArtifactType::insert($data);
    }
}
