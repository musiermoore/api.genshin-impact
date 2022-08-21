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

    public function baseArtifactValues()
    {
        return $this->belongsToMany(
            Rarity::class,
            'artifact_base_characteristics'
        )->withPivot(['value', 'level']);
    }

    public function extraArtifactValues()
    {
        return $this->belongsToMany(
            Rarity::class,
            'artifact_extra_characteristics'
        )->withPivot(['value', 'tier']);
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

    public static function getDefaultCharacteristics()
    {
        $unusedCharacteristics = ['hp-percent', 'atk-percent', 'def-percent', 'max-stamina'];
        $characteristics = Characteristic::query()
            ->whereNotIn('slug', $unusedCharacteristics)
            ->get()
            ->keyBy('slug')
            ->toArray();

        foreach ($characteristics as $key => &$characteristic) {
            $value = 0;

            if ($key === 'crit-rate') {
                $value = 5;
            } elseif ($key === 'crit-dmg') {
                $value = 50;
            } elseif ($key === 'energy-recharge') {
                $value = 100;
            }

            $characteristic['value'] = $value;
        }

        return $characteristics;
    }

    public static function calculateCharacterCharacteristics($characteristics)
    {
        $calculatedCharacteristics = self::getDefaultCharacteristics();

        foreach ($characteristics as $characteristic) {
            if ($characteristic['slug'] === 'hp-percent') {
                $calculatedCharacteristics['hp']['pivot']['value'] +=
                    floor($calculatedCharacteristics['hp']['pivot']['value'] * $characteristic['pivot']['value'] / 100);
            } elseif ($characteristic['slug'] === 'atk-percent') {
                $calculatedCharacteristics['atk']['pivot']['value'] +=
                    floor($calculatedCharacteristics['atk']['pivot']['value'] * $characteristic['pivot']['value'] / 100);
            } elseif ($characteristic['slug'] === 'def-percent') {
                $calculatedCharacteristics['def']['pivot']['value'] +=
                    floor($calculatedCharacteristics['def']['pivot']['value'] * $characteristic['pivot']['value'] / 100);
            } else {
                $calculatedCharacteristics[$characteristic['slug']]['pivot']['value'] = $characteristic['pivot']['value'];
            }
        }

        return $calculatedCharacteristics;
    }
}
