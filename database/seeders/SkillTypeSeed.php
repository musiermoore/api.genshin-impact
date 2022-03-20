<?php

namespace Database\Seeders;

use App\Models\SkillType;
use Illuminate\Database\Seeder;

class SkillTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type' => 'Обычная атака', 'slug' => 'normal-attack'],
            ['type' => 'Элементальный навык', 'slug' => 'elemental-skill'],
            ['type' => 'Альтернативный спринт', 'slug' => 'alternate-sprint'],
            ['type' => 'Взрыв стихий', 'slug' => 'elemental-burst'],
            ['type' => 'Пассивный талант (1 вознесение)', 'slug' => 'passive-1'],
            ['type' => 'Пассивный талант (4 вознесение)', 'slug' => 'passive-4'],
            ['type' => 'Пассивный талант', 'slug' => 'passive']
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        SkillType::insert($data);
    }
}
