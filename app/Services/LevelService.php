<?php

namespace App\Services;

use App\Models\Ascension;
use App\Models\Level;

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
}
