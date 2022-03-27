<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
