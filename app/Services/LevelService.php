<?php

namespace App\Services;

use App\Models\Ascension;
use App\Models\Level;
use App\Models\Weapon;

class LevelService
{
    public function getCharacterLevelsWithAscensions()
    {
        $characterLevels = Level::getCharacterLevels();
        $ascensions = Ascension::getCharacterAscensions();

        $levelsWithAscensions = [
            [
                'level_id' => $characterLevels[1]['id'],
                'ascension_id' => $ascensions[0]['id']
            ],
            [
                'level_id' => $characterLevels[20]['id'],
                'ascension_id' => $ascensions[0]['id']
            ],
            [
                'level_id' => $characterLevels[20]['id'],
                'ascension_id' => $ascensions[1]['id']
            ],
            [
                'level_id' => $characterLevels[40]['id'],
                'ascension_id' => $ascensions[1]['id']
            ],
            [
                'level_id' => $characterLevels[40]['id'],
                'ascension_id' => $ascensions[2]['id']
            ],
            [
                'level_id' => $characterLevels[50]['id'],
                'ascension_id' => $ascensions[2]['id']
            ],
            [
                'level_id' => $characterLevels[50]['id'],
                'ascension_id' => $ascensions[3]['id']
            ],
            [
                'level_id' => $characterLevels[60]['id'],
                'ascension_id' => $ascensions[3]['id']
            ],
            [
                'level_id' => $characterLevels[60]['id'],
                'ascension_id' => $ascensions[4]['id']
            ],
            [
                'level_id' => $characterLevels[70]['id'],
                'ascension_id' => $ascensions[4]['id']
            ],
            [
                'level_id' => $characterLevels[70]['id'],
                'ascension_id' => $ascensions[5]['id']
            ],
            [
                'level_id' => $characterLevels[80]['id'],
                'ascension_id' => $ascensions[5]['id']
            ],
            [
                'level_id' => $characterLevels[80]['id'],
                'ascension_id' => $ascensions[6]['id']
            ],
            [
                'level_id' => $characterLevels[90]['id'],
                'ascension_id' => $ascensions[6]['id']
            ]
        ];

        return $levelsWithAscensions;
    }

    public function getWeaponLevelsWithAscensions()
    {
        $weaponLevels = Weapon::getWeaponLevels();
        $ascensions = Ascension::getCharacterAscensions();

        return [
            [
                'level_id' => $weaponLevels[1]['id'],
                'ascension_id' => $ascensions[0]['id'],
                'ascension' => $ascensions[0]['ascension'],
                'max_level' => $ascensions[0]['max_level'],
                'level' => $weaponLevels[1]['level']
            ],
            [
                'level_id' => $weaponLevels[20]['id'],
                'ascension_id' => $ascensions[0]['id'],
                'ascension' => $ascensions[0]['ascension'],
                'max_level' => $ascensions[0]['max_level'],
                'level' => $weaponLevels[20]['level']
            ],
            [
                'level_id' => $weaponLevels[20]['id'],
                'ascension_id' => $ascensions[1]['id'],
                'ascension' => $ascensions[1]['ascension'],
                'max_level' => $ascensions[1]['max_level'],
                'level' => $weaponLevels[20]['level']
            ],
            [
                'level_id' => $weaponLevels[40]['id'],
                'ascension_id' => $ascensions[1]['id'],
                'ascension' => $ascensions[1]['ascension'],
                'max_level' => $ascensions[1]['max_level'],
                'level' => $weaponLevels[40]['level']
            ],
            [
                'level_id' => $weaponLevels[40]['id'],
                'ascension_id' => $ascensions[2]['id'],
                'ascension' => $ascensions[2]['ascension'],
                'max_level' => $ascensions[2]['max_level'],
                'level' => $weaponLevels[40]['level']
            ],
            [
                'level_id' => $weaponLevels[50]['id'],
                'ascension_id' => $ascensions[2]['id'],
                'ascension' => $ascensions[2]['ascension'],
                'max_level' => $ascensions[2]['max_level'],
                'level' => $weaponLevels[50]['level']
            ],
            [
                'level_id' => $weaponLevels[50]['id'],
                'ascension_id' => $ascensions[3]['id'],
                'ascension' => $ascensions[3]['ascension'],
                'max_level' => $ascensions[3]['max_level'],
                'level' => $weaponLevels[50]['level']
            ],
            [
                'level_id' => $weaponLevels[60]['id'],
                'ascension_id' => $ascensions[3]['id'],
                'ascension' => $ascensions[3]['ascension'],
                'max_level' => $ascensions[3]['max_level'],
                'level' => $weaponLevels[60]['level']
            ],
            [
                'level_id' => $weaponLevels[60]['id'],
                'ascension_id' => $ascensions[4]['id'],
                'ascension' => $ascensions[4]['ascension'],
                'max_level' => $ascensions[4]['max_level'],
                'level' => $weaponLevels[60]['level']
            ],
            [
                'level_id' => $weaponLevels[70]['id'],
                'ascension_id' => $ascensions[4]['id'],
                'ascension' => $ascensions[4]['ascension'],
                'max_level' => $ascensions[4]['max_level'],
                'level' => $weaponLevels[70]['level']
            ],
            [
                'level_id' => $weaponLevels[70]['id'],
                'ascension_id' => $ascensions[5]['id'],
                'ascension' => $ascensions[5]['ascension'],
                'max_level' => $ascensions[5]['max_level'],
                'level' => $weaponLevels[70]['level']
            ],
            [
                'level_id' => $weaponLevels[80]['id'],
                'ascension_id' => $ascensions[5]['id'],
                'ascension' => $ascensions[5]['ascension'],
                'max_level' => $ascensions[5]['max_level'],
                'level' => $weaponLevels[80]['level']
            ],
            [
                'level_id' => $weaponLevels[80]['id'],
                'ascension_id' => $ascensions[6]['id'],
                'ascension' => $ascensions[6]['ascension'],
                'max_level' => $ascensions[6]['max_level'],
                'level' => $weaponLevels[80]['level']
            ],
            [
                'level_id' => $weaponLevels[90]['id'],
                'ascension_id' => $ascensions[6]['id'],
                'ascension' => $ascensions[6]['ascension'],
                'max_level' => $ascensions[6]['max_level'],
                'level' => $weaponLevels[90]['level']
            ]
        ];
    }
}
