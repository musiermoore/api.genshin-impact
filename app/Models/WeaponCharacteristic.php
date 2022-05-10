<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponCharacteristic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'weapon_id',
        'level_id',
        'ascension_id',
        'base_atk',
        'sub_stat',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function ascension()
    {
        return $this->belongsTo(Ascension::class);
    }
}
