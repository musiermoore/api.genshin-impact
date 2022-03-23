<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'image_type_id'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function imageType()
    {
        return $this->belongsTo(ImageType::class);
    }
}
