<?php

namespace Database\Seeders;

use App\Models\ImageType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArtifactSetImageTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageTypes = [
            [
                'type' => 'Цветок жизни',
                'slug' => Str::slug('Artifact Flower of Life')
            ],
            [
                'type' => 'Перо смерти',
                'slug' => Str::slug('Artifact Plume of Death')
            ],
            [
                'type' => 'Пески времени',
                'slug' => Str::slug('Artifact Sands of Eon')
            ],
            [
                'type' => 'Кубок пространства',
                'slug' => Str::slug('Artifact Goblet of Eonothem')
            ],
            [
                'type' => 'Корона разума',
                'slug' => Str::slug('Artifact Circlet of Logos')
            ]
        ];

        foreach ($imageTypes as &$imageType) {
            $imageType['created_at'] = Carbon::now();
            $imageType['updated_at'] = Carbon::now();
        }

        ImageType::query()->insert($imageTypes);
    }
}
