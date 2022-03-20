<?php

namespace Database\Seeders;

use App\Models\Element;
use Illuminate\Database\Seeder;

class ElementSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['element' => 'Электро', 'slug' => 'electro'],
            ['element' => 'Пиро', 'slug' => 'pyro'],
            ['element' => 'Гео', 'slug' => 'geo'],
            ['element' => 'Дендро', 'slug' => 'dendro'],
            ['element' => 'Анемо', 'slug' => 'anemo'],
            ['element' => 'Крио', 'slug' => 'cryo'],
            ['element' => 'Гидро', 'slug' => 'hydro']
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        Element::insert($data);
    }
}
