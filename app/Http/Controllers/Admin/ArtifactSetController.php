<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArtifactSetStoreRequest;
use App\Http\Requests\Admin\ArtifactSetUpdateRequest;
use App\Models\ArtifactSet;

class ArtifactSetController extends Controller
{
    public function index()
    {
        $artifactSets = ArtifactSet::with('images')
            ->get();

        $data = [
            'artifact_sets' => $artifactSets
        ];

        return $this->successResponse($data);
    }

    public function show($id)
    {
        $artifactSet = ArtifactSet::with('images')
            ->where('id', '=', $id)
            ->first();

        $data = [
            'artifact_set' => $artifactSet
        ];

        return $this->successResponse($data);
    }

    public function store(ArtifactSetStoreRequest $request)
    {
        $data = $request->validated();

        $artifactSet = ArtifactSet::query()->create($data);

        $data = [
            'artifact_set' => $artifactSet
        ];

        return $this->successResponse($data, 'Сет для артефакта создан.');
    }

    public function update(ArtifactSetUpdateRequest $request, $id)
    {
        $data = $request->validated();

        ArtifactSet::query()
            ->where('id', '=', $id)
            ->update($data);

        return $this->successResponse(null, 'Сет для артефакта обновлен.');
    }

    public function delete($id)
    {
        ArtifactSet::query()
            ->where('id', '=', $id)
            ->delete();

        return $this->successResponse(null, 'Сет для артефакта удален.');
    }
}
