<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_id',
        'name',
        'slug',
        'element_id',
        'weapon_type_id'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function star()
    {
        return $this->belongsTo(Star::class);
    }

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function characterLevels()
    {
        return $this->hasMany(CharacterLevel::class);
    }

    public function characteristics()
    {
        return $this->hasManyThrough(Characteristic::class, CharacterLevel::class);
    }

    public static function getCalculatorCharacters($page = 0)
    {
        $limit = 10;

        $characterIds = [];
        if (!empty($page)) {
            $characterIds = Character::query()
                ->limit($limit)
                ->offset($limit * $page)
                ->orderBy('name')
                ->get()
                ->pluck('id')
                ->toArray();
        }

        return DB::table('characters')
            ->select([
                DB::raw(
                    'characters.id AS character_id, characters.name AS character_name, characters.slug AS character_slug'
                ),
                DB::raw(
                    'stars.star, weapon_types.type AS weapon_type, weapon_types.slug AS weapon_type_slug'
                ),
                DB::raw(
                    'elements.element, elements.slug AS element_slug'
                ),
                DB::raw(
                    'character_levels.id AS character_level_id, levels.level, ascensions.ascension'
                ),
                DB::raw(
                    'character_characteristics.characteristic_id, ' .
                    'character_characteristics.value AS characteristic_value'
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
                $join->on('images.imageable_id', '=', 'characters.id');
                $join->where('images.imageable_type', '=', 'App\Models\Character');
            })
            ->leftJoin('image_types', 'images.image_type_id', '=', 'image_types.id')
            ->leftJoin('character_levels', 'characters.id', '=', 'character_levels.character_id')
            ->leftJoin('character_characteristics',
                'character_levels.id', '=', 'character_characteristics.character_level_id'
            )
            ->leftJoin('levels', 'character_levels.level_id', '=', 'levels.id')
            ->leftJoin('characteristics',
                'character_characteristics.characteristic_id', '=', 'characteristics.id'
            )
            ->leftJoin('characteristic_types',
                'characteristics.characteristic_type_id', '=', 'characteristic_types.id'
            )
            ->leftJoin('ascensions', 'character_levels.ascension_id', '=', 'ascensions.id')
            ->leftJoin('elements', 'characters.element_id', '=', 'elements.id')
            ->leftJoin('stars', 'characters.star_id', '=', 'stars.id')
            ->leftJoin('weapon_types', 'characters.weapon_type_id', '=', 'weapon_types.id')
            ->when(!empty($page), function ($query) use ($characterIds) {
                $query->whereIn('characters.id', $characterIds);
            })
            ->orderBy('characters.name')
            ->orderBy('ascensions.ascension')
            ->orderBy('levels.level')
            ->get()
            ->toArray();
    }

    public static function compactCharacterDataForCalculator($characters)
    {
        $groupedCharacters = [];
        foreach ($characters as $character) {
            $character = (array) $character;

            $characterId = $character['character_id'];

            if (empty($groupedCharacters[$characterId]['id'])) {
                // character
                $groupedCharacters[$characterId]['id'] = $characterId;
                $groupedCharacters[$characterId]['name'] = $character['character_name'];
                $groupedCharacters[$characterId]['slug'] = $character['character_slug'];

                // images
                $groupedCharacters[$characterId]['images'][$character['image_slug']] = [
                    'path' => $character['image_path'],
                    'image_type' => [
                        'type' => $character['image_type'],
                        'slug' => $character['image_slug']
                    ]
                ];

                // elements
                $groupedCharacters[$characterId]['element'] = [
                    'element' => $character['element'],
                    'slug' => $character['element_slug']
                ];

                // stars
                $groupedCharacters[$characterId]['star']['star'] = $character['star'];

                // weapon types
                $groupedCharacters[$characterId]['weapon_type'] = [
                    'type' => $character['weapon_type'],
                    'slug' => $character['weapon_type_slug']
                ];
            }

            // character level
            $characterLevelId = $character['character_level_id'];

            if (empty($groupedCharacters[$characterId]['character_levels'][$characterLevelId]['ascension'])) {
                $groupedCharacters[$characterId]['character_levels'][$characterLevelId]['ascension'] = [
                    'ascension' => $character['ascension'],
                    'max_level' => Ascension::getMaxLevel($character['ascension'])
                ];
                $groupedCharacters[$characterId]['character_levels'][$characterLevelId]['level'] = [
                    'level' => $character['level']
                ];
            }

            $groupedCharacters[$characterId]['character_levels'][$characterLevelId]['characteristics'][] = [
                'characteristic_id' => $character['characteristic_id'],
                'name' => $character['characteristic_name'],
                'slug' => $character['characteristic_slug'],
                'in_percent' => $character['in_percent'],
                'pivot' => [
                    'value' => $character['characteristic_value']
                ]
            ];
        }

        foreach ($groupedCharacters as &$character) {
            $character['character_levels'] = array_values($character['character_levels']);
            $character['images'] = array_values($character['images']);
        }

        return $groupedCharacters;
    }
}
