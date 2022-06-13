<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_id',
        'name',
        'slug',
        'element_id',
        'weapon_type_id'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function star()
    {
        return $this->belongsTo(Star::class);
    }

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function characterLevels()
    {
        return $this->hasMany(CharacterLevel::class);
    }

    public function characteristics()
    {
        return $this->hasManyThrough(Characteristic::class, CharacterLevel::class);
    }

    public function getNameAttribute()
    {
        return __('characters/characters.' . $this->attributes['slug']);
    }

    public static function getCalculatorCharacters($page = 0): array
    {
        $limit = 15;

        return Character::query()
            ->select([
                DB::raw('characters.id, characters.name, characters.slug'),
                DB::raw('stars.star, weapon_types.type AS weapon_type, weapon_types.slug AS weapon_type_slug'),
                DB::raw('elements.element, elements.slug AS element_slug'),
                DB::raw('images.path AS image_path, image_types.type AS image_type, image_types.slug AS image_slug')
            ])
            ->leftJoin('elements', 'elements.id', '=', 'characters.element_id')
            ->leftJoin('weapon_types', 'weapon_types.id', '=', 'characters.weapon_type_id')
            ->leftJoin('stars', 'stars.id', '=', 'characters.star_id')
            ->leftJoin('images', function ($join) {
                $join->on('images.imageable_id', '=', 'characters.id');
                $join->where('images.imageable_type', '=', Character::class);
            })
            ->leftJoin('image_types', 'images.image_type_id', '=', 'image_types.id')
            ->with([
                'characterLevels' => function ($with) {
                    $with->select([
                        'character_levels.id', 'character_levels.character_id',
                        'levels.level', 'ascensions.ascension', 'ascensions.max_level'
                    ]);
                    $with->leftJoin('ascensions', 'ascensions.id', '=', 'character_levels.ascension_id');
                    $with->leftJoin('levels', 'levels.id', '=', 'character_levels.level_id');
                    $with->orderBy('ascensions.ascension')->orderBy('levels.level');
                },
                'characterLevels.characteristics' => function ($with) {
                    $with->select([
                        DB::raw('stats.id AS characteristic_id'), 'stats.name', 'stats.slug', 'stats.in_percent',
                        'character_characteristics.value'
                    ]);
                    $with->leftJoin(DB::raw('characteristics AS stats'),
                        'character_characteristics.characteristic_id', '=', 'stats.id'
                    );
                }
            ])
            ->orderBy('characters.name')
            ->when(!empty($page), function ($when) use ($page, $limit) {
                $when->limit($page * $limit);
                $when->offset(($page - 1) * $limit);
            })
            ->get()
            ->toArray();
    }

    public static function compactCharacterDataForCalculator($characters): array
    {
        return array_map(function ($character) {
            $character['element'] = [
                'element' => $character['element'],
                'slug' => $character['element_slug']
            ];

            $character['weapon_type'] = [
                'type' => $character['weapon_type'],
                'slug' => $character['weapon_type_slug']
            ];

            $character['images'][] = [
                'path' => $character['image_path'],
                'image_type' => [
                    'type' => $character['image_type'],
                    'slug' => $character['image_slug']
                ]
            ];


            unset(
                $character['image_path'],
                $character['image_slug'],
                $character['image_type'],
                $character['element_slug'],
                $character['weapon_type_slug']
            );

            return $character;
        }, $characters);
    }
}
