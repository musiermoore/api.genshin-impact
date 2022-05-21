<?php

namespace App\Http\Controllers;

use App\Models\Weapon;

class WeaponController extends Controller
{
    public function getCalculatorWeapons()
    {
        $weapons = Weapon::getCalculatorWeapons();

        $data = [
            'weapons' => Weapon::compactWeaponDataForCalculator($weapons)
        ];

        return $this->successResponse($data);
    }
}
