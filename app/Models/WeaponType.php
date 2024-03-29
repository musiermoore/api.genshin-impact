<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug',
        'created_at',
        'updated_at'
    ];
}
