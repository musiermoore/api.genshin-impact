<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'artifact_set_id',
        'artifact_type_id',
        'name',
        'slug'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function (&$model) {
            if (empty($model['slug'])) {
                $model['slug'] = $model['name'];
            }

            $model['slug'] = Str::slug($model['slug']);
        });
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function artifactSet()
    {
        return $this->belongsTo(ArtifactSet::class);
    }

    public function artifactType()
    {
        return $this->belongsTo(ArtifactType::class);
    }
}
