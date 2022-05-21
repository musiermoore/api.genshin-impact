<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_type_id',
        'star_id',
        'name',
        'slug',
        'main_characteristic_id',
        'description'
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

    public function subStat()
    {
        return $this->belongsTo(Characteristic::class)->withTrashed();
    }

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function characteristics()
    {
        return $this->hasMany(WeaponCharacteristic::class);
    }

    public static function getWeaponLevels()
    {
        $levels = [
            1, 20, 40, 50, 60, 70, 80, 90
        ];

        return Level::query()
            ->select(['id', 'level'])
            ->whereIn('level', $levels)
            ->get()
            ->keyBy('level')
            ->toArray();

    }
}
