<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'level_id',
        'ascension_id'
    ];

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'character_characteristics')
            ->withPivot(['value']);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function ascension()
    {
        return $this->belongsTo(Ascension::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public static function getCharacterLevels()
    {
        $levels = [
            1, 20, 40, 50, 60, 70, 80, 90
        ];

        return $levels;
    }
}
