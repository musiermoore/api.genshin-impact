<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculatorRequest;
use App\Models\Character;
use App\Models\Characteristic;

class CharacterController extends Controller
{
    public function getCalculatorCharacters(CalculatorRequest $request)
    {
        $page = empty($request->page) ? 0 : $request->page;

        $characters = Character::getCalculatorCharacters($page);
        $groupedCharacters = Character::compactCharacterDataForCalculator($characters);

        $data = [
            'characters' => $groupedCharacters
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
