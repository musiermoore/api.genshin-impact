<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'login' => 'musiermoore',
                'email' => 'markowillz@gmail.com',
                'name'  => 'Сашка',
                'gender' => 1,
                'password' => Hash::make('123123'),
            ],
            [
                'login' => 'heebath',
                'email' => 'r.p200111@gmail.com',
                'name'  => 'Ромочка',
                'gender' => 1,
                'password' => Hash::make('123123')
            ],
            [
                'login' => 'neo',
                'email' => 'dembitskayasy@mail.ru',
                'name'  => 'Настька',
                'gender' => 0,
                'password' => Hash::make('123123')
            ],
        ];

        $users = array_map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::now();
            $item['updated_at'] = \Carbon\Carbon::now();

            return $item;
        }, $users);

        $existingUsers = User::query()
            ->whereIn('login', array_column($users, 'login'))
            ->pluck('login')
            ->toArray();

        $users = array_filter($users, function ($item) use ($existingUsers) {
            return !in_array($item['login'], $existingUsers);
        });

        User::query()->insert($users);
    }
}
