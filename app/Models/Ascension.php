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
}
