<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_type_id',
        'rarity_id',
        'name',
        'slug',
        'main_characteristic_id',
        'description'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    public function subStat()
    {
        return $this->belongsTo(Characteristic::class)->withTrashed();
    }

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function characteristics()
    {
        return $this->hasMany(WeaponCharacteristic::class);
    }

    public static function getWeaponLevels()
    {
        $levels = [
            1, 20, 40, 50, 60, 70, 80, 90
        ];

        return Level::query()
            ->select(['id', 'level'])
            ->whereIn('level', $levels)
            ->get()
            ->keyBy('level')
            ->toArray();
    }

    public static function getCalculatorWeapons()
    {
        return DB::table('weapons')
            ->select([
                DB::raw(
                    'weapons.id AS weapon_id, weapons.name AS weapon_name, weapons.slug AS weapon_slug, weapons.sub_stat_id'
                ),
                DB::raw(
                    'rarities.rarity, weapon_types.type AS weapon_type, weapon_types.slug AS weapon_type_slug'
                ),
                DB::raw(
                    'weapon_characteristics.id AS weapon_characteristics_id, levels.level, ascensions.ascension'
                ),
                DB::raw(
                    'weapon_characteristics.base_atk, weapon_characteristics.sub_stat'
                ),
                DB::raw(
                    'images.path AS image_path, image_types.type AS image_type, image_types.slug AS image_slug'
                ),
                DB::raw(
                    'characteristics.name as characteristic_name, characteristics.slug as characteristic_slug, ' .
                    'characteristics.in_percent'
                )
            ])
            ->leftJoin('images', function ($join) {
                $join->on('images.imageable_id', '=', 'weapons.id');
                $join->where('images.imageable_type', '=', 'App\Models\Weapon');
            })
            ->leftJoin('image_types', 'images.image_type_id', '=', 'image_types.id')
            ->leftJoin('weapon_characteristics',
                'weapons.id', '=', 'weapon_characteristics.weapon_id'
            )
            ->leftJoin('levels', 'weapon_characteristics.level_id', '=', 'levels.id')
            ->leftJoin('ascensions', 'weapon_characteristics.ascension_id', '=', 'ascensions.id')
            ->leftJoin('characteristics',
                'weapons.sub_stat_id', '=', 'characteristics.id'
            )
            ->leftJoin('rarities', 'weapons.rarity_id', '=', 'rarities.id')
            ->leftJoin('weapon_types', 'weapons.weapon_type_id', '=', 'weapon_types.id')
            ->orderBy('rarities.rarity')
            ->orderBy('weapons.name')
            ->orderBy('ascensions.ascension')
            ->orderBy('levels.level')
            ->get()
            ->toArray();
    }

    public static function compactWeaponDataForCalculator($weapons): array
    {
        $groupedWeapons = [];
        foreach ($weapons as $weapon) {
            $weapon = (array) $weapon;

            $weaponId = $weapon['weapon_id'];

            if (empty($groupedWeapons[$weaponId]['id'])) {
                // weapon
                $groupedWeapons[$weaponId]['id'] = $weaponId;
                $groupedWeapons[$weaponId]['name'] = $weapon['weapon_name'];
                $groupedWeapons[$weaponId]['slug'] = $weapon['weapon_slug'];
                $groupedWeapons[$weaponId]['sub_stat_id'] = $weapon['sub_stat_id'];

                $groupedWeapons[$weaponId]['sub_stat'] = [
                    'id' => $weapon['sub_stat_id'],
                    'name' => $weapon['characteristic_name'],
                    'slug' => $weapon['characteristic_slug'],
                    'in_percent' => $weapon['in_percent']
                ];

                // images
                $groupedWeapons[$weaponId]['images'][$weapon['image_slug']] = [
                    'path' => $weapon['image_path'],
                    'image_type' => [
                        'type' => $weapon['image_type'],
                        'slug' => $weapon['image_slug']
                    ]
                ];

                // rarities
                $groupedWeapons[$weaponId]['rarity']['rarity'] = $weapon['rarity'];

                // weapon types
                $groupedWeapons[$weaponId]['weapon_type'] = [
                    'type' => $weapon['weapon_type'],
                    'slug' => $weapon['weapon_type_slug']
                ];
            }

            $groupedWeapons[$weaponId]['characteristics'][] = [
                'in_percent' => $weapon['in_percent'],
                'base_atk' => $weapon['base_atk'],
                'sub_stat' => [
                    'value' => $weapon['sub_stat']
                ],
                'ascension' => [
                    'ascension' => $weapon['ascension'],
                    'max_level' => Ascension::getMaxLevel($weapon['ascension'])
                ],
                'level' => [
                    'level' => $weapon['level']
                ]
            ];
        }

        foreach ($groupedWeapons as &$weapon) {
            $weapon['images'] = array_values($weapon['images']);
        }

        return array_values($groupedWeapons);
    }
}
