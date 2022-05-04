<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ascension extends Model
{
    use HasFactory;

    protected $fillable = [
        'ascension',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'max_level'
    ];

    public static function getCharacterAscensions()
    {
        return Ascension::query()
            ->get()
            ->keyBy('ascension')
            ->toArray();
    }

    public function getMaxLevelAttribute()
    {
        return Ascension::getMaxLevel($this->ascension);
    }

    public static function getMaxLevel($ascension)
    {
        $maxLevel = 0;

        if ($ascension === 0) {
            $maxLevel = 20;
        } elseif ($ascension === 1) {
            $maxLevel = 40;
        } elseif ($ascension === 2) {
            $maxLevel = 50;
        } elseif ($ascension === 3) {
            $maxLevel = 60;
        } elseif ($ascension === 4) {
            $maxLevel = 70;
        } elseif ($ascension === 5) {
            $maxLevel = 80;
        } elseif ($ascension === 6) {
            $maxLevel = 90;
        }

        return $maxLevel;
    }
}
