<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'in_percent',
        'characteristic_type_id'
    ];

    public function characteristicType()
    {
        return $this->belongsTo(CharacteristicType::class);
    }
}
