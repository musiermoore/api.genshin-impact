<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArtifactSet extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function artifacts()
    {
        return $this->hasMany(Artifact::class);
    }
}
