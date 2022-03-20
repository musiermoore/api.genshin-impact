<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Европа', 'slug' => 'europe'],
            ['name' => 'Америка', 'slug' => 'america'],
            ['name' => 'Азия', 'slug' => 'asia'],
            ['name' => 'SAR', 'slug' => 'sar']
        ];

        $data = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $data);

        Server::insert($data);
    }
}
