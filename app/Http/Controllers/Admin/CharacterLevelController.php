<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCharacteristicToCharacterRequest;
use App\Models\Character;
use App\Models\Characteristic;

class CharacterLevelController extends Controller
{
    public function getCharacterCharacteristics($characterId, $levelId)
    {
        $characteristics = Characteristic::all();

        $character = Character::where('id', $characterId)->first();

        $characterLevel = $character->characterLevels()
            ->with([
                'character',
                'characteristics' => function ($query) {
                    $query->orderBy('id');
                },
                'level',
                'ascension'
            ])
            ->where('id', $levelId)
            ->first();

        $data = [
            'character_level' => $characterLevel,
            'characteristics' => $characteristics
        ];

        return $this->successResponse($data);
    }

    public function addCharacteristicToCharacter(AddCharacteristicToCharacterRequest $request, $characterId, $levelId)
    {
        $data = $request->validated();

        $character = Character::query()
            ->where('id', $characterId)
            ->first();

        if (empty($character)) {
            $this->errorResponse(404, 'Персонаж не найден.');
        }

        $characterLevel = $character->characterLevels()
            ->where('id', $levelId)
            ->first();

        if (empty($characterLevel)) {
            $this->errorResponse(404, 'Персонаж не найден.');
        }

        $characterLevel->characteristics()
            ->wherePivot('characteristic_id', $data['characteristic_id'])
            ->detach();

        $characterLevel->characteristics()->attach($levelId, [
            'characteristic_id'  => $data['characteristic_id'],
            'value'              => $data['value']
        ]);

        return $this->successResponse(null, 'Характеристика добавлена.');
    }
}
