<?php

namespace App\Http\Controllers;

use App\Models\Ascension;
use App\Models\Characteristic;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    public function getCalculatorCharacters()
    {
        $characters = DB::table('characters')
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
            ->orderBy('characters.name')
            ->get()
            ->toArray();

        $groupedCharacters = [];
        foreach ($characters as $character) {
            $character = (array) $character;

            $characterId = $character['character_id'];

            // character
            $groupedCharacters[$characterId]['id'] = $characterId;
            $groupedCharacters[$characterId]['name'] = $character['character_name'];
            $groupedCharacters[$characterId]['slug'] = $character['character_slug'];

            // images
            $groupedCharacters[$characterId]['images'][] = [
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

            // character level
            $characterLevelId = $character['character_level_id'];

            $groupedCharacters[$characterId]['character_levels'][$characterLevelId]['ascension'] = [
                'ascension' => $character['ascension'],
                'max_level' => Ascension::getMaxLevel($character['ascension'])
            ];
            $groupedCharacters[$characterId]['character_levels'][$characterLevelId]['level'] = [
                'level' => $character['level']
            ];
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
        }

        $data = [
            'characters' => array_values($groupedCharacters)
        ];

        return $this->successResponse($data);
    }

    public function getCalculatorCharacteristics()
    {
        $data = [
            'characteristics' => Characteristic::getDefaultCharacteristics()
        ];

        return $this->successResponse($data);
    }
}
