<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtifactType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug'
    ];

    public static function getArtifactTypeIdBySlug($slug)
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->value('id');
    }
}
