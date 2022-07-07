<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArtifactStoreRequest;
use App\Http\Requests\Admin\ArtifactUpdateRequest;
use App\Http\Traits\ImageUpload;
use App\Models\Artifact;
use App\Models\ImageType;

class ArtifactController extends Controller
{
    use ImageUpload;

    public function index()
    {
        $artifacts = Artifact::with('images')
            ->get();

        $data = [
            'artifacts' => $artifacts
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $artifact = Artifact::with('images')
            ->where('id', '=', $id)
            ->first();

        $data = [
            'artifact' => $artifact
        ];

        return $this->successResponse($data);
    }

    public function store(ArtifactStoreRequest $request)
    {
        $data = $request->validated();

        $artifact = Artifact::query()->create($data);

        if (!empty($request->file('image'))) {
            $imageType = ImageType::query()
                ->where('slug', ImageType::MAIN)
                ->first();

            $artifact->image()->create([
                'path' => $this->uploadImage($data['image'], 'artifacts', $artifact['slug']),
                'image_type_id' => $imageType['id']
            ]);
        }

        $data = [
            'artifact' => $artifact
        ];

        return $this->successResponse($data, 'Артефакт создан.');
    }

    public function update(ArtifactUpdateRequest $request, $id)
    {
        $data = $request->validated();

        Artifact::query()
            ->where('id', '=', $id)
            ->update($data);

        return $this->successResponse(null, 'Артефакт обновлен.');
    }

    public function delete($id)
    {
        Artifact::query()
            ->where('id', '=', $id)
            ->delete();

        return $this->successResponse(null, 'Артефакт удален.');
    }
}
