<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait ImageUpload
{
    public function uploadImage($file, $fileName = null): ?string
    {
        $imageName = !empty($fileName)
            ? $fileName
            : Str::random(20);

        $ext = strtolower($file->getClientOriginalExtension());

        $imageNameWithExt = $imageName . '.' . $ext;

        $savePath = 'images/characters/';

        $imageUrl = $savePath . $imageNameWithExt;

        $success = $file->storeAs($savePath, $imageNameWithExt);

        return $success ? $imageUrl : null;
    }
}
