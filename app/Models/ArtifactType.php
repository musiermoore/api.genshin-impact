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

    public const FLOWER_OF_LIFE = 'flower-of-life';
    public const PLUME_OF_DEATH = 'plume-of-death';
    public const SANDS_OF_EON = 'sands-of-eon';
    public const GOBLET_OF_EONOTHEM = 'goblet-of-eonothem';
    public const CIRCLET_OF_LOGOS = 'circlet-of-logos';

    /**
     * Each artifact type has one or some characteristics.
     *
     * For example:
     * - flower of life - HP.
     * - plume of death - ATK
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mainCharacteristics(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Characteristic::class);
    }

    public static function getArtifactTypeIdBySlug($slug)
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->value('id');
    }
}
