<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Characteristic;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function getCalculatorCharacters()
    {
        $characters = Character::with([
            'images.imageType',
            'element',
            'star',
            'weaponType',
            'characterLevels.characteristics',
            'characterLevels.level',
            'characterLevels.ascension'
        ])->orderBy('name')
            ->get()
            ->toArray();

        foreach ($characters as $characterKey => $character) {
            foreach ($character['character_levels'] as $characterLevelKey => $characterLevel) {
                $characters[$characterKey]['character_levels'][$characterLevelKey]['characteristics'] =
                    Characteristic::calculateCharacterCharacteristics($characterLevel['characteristics']);
            }
        }

        $data = [
            'characters' => $characters
        ];

        return $this->successResponse($data);
    }
}
