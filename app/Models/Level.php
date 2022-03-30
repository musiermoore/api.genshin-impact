<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'created_at',
        'updated_at'
    ];

    public static function getCharacterLevels()
    {
        return Level::query()
            ->whereIn('level', CharacterLevel::getCharacterLevels())
            ->get()
            ->keyBy('level')
            ->toArray();
    }
}
