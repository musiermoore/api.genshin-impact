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

        $data = [
            'characters' => $characters
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
