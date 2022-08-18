<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    use HasFactory;

    protected $fillable = [
        'rarity',
        'created_at',
        'updated_at'
    ];

    public function artifactSets()
    {
        $this->belongsToMany(ArtifactSet::class);
    }
}
