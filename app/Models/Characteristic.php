<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Characteristic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'in_percent',
        'characteristic_type_id'
    ];

    public const WEAPON_CHARACTERISTIC_SLUGS = [
        'crit-rate',
        'crit-dmg',
        'energy-recharge',
        'physical-dmg-bonus',
        'none'
    ];

    public function characteristicType()
    {
        return $this->belongsTo(CharacteristicType::class);
    }

    public static function getWeaponCharacteristics()
    {
        $hideCharacteristics = [
            'max-stamina',
            'def',
            'hp',
            'atk'
        ];

        return self::withTrashed()
            ->select('characteristics.*', 'characteristic_types.type')
            ->leftJoin('characteristic_types',
                'characteristic_types.id', '=', 'characteristics.characteristic_type_id'
            )
            ->where(function ($query) use ($hideCharacteristics) {
                $query->where('characteristic_types.slug', '=', CharacteristicType::BASIC)
                    ->whereNotIn('characteristics.slug', $hideCharacteristics);
            })
            ->orWhere(function ($query) {
                $query->whereIn('characteristics.slug', self::WEAPON_CHARACTERISTIC_SLUGS);
            })
            ->orderByDesc('characteristics.deleted_at')
            ->orderBy('characteristics.characteristic_type_id')
            ->orderByDesc('characteristics.in_percent')
            ->orderBy('characteristics.slug')
            ->get();
    }
}
