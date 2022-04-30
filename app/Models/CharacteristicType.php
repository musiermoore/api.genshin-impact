<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacteristicType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug',
        'created_at',
        'updated_at'
    ];

    public const BASIC = 'basic';
    public const SECONDARY = 'secondary';
    public const ELEMENTS = 'elements';

}
