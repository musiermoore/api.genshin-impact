<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CharacterStoreRequest;
use App\Http\Requests\Admin\CharacterUpdateRequest;
use App\Http\Traits\ImageUpload;
use App\Models\Character;
use App\Models\Element;
use App\Models\Image;
use App\Models\ImageType;
use App\Models\Star;
use App\Models\WeaponType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CharacterController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index()
    {
        $characters = Character::query()
            ->with('images.imageType')
            ->get();

        $data = [
            'characters' => $characters
        ];

        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(CharacterStoreRequest $request)
    {
        $image = null;

        $saveData = $request->validated();

        $saveData['slug'] = !empty($saveData['slug'])
            ? Str::slug($saveData['slug'])
            : Str::slug($saveData['name']);

        $character = Character::query()->create($saveData);

        if (!empty($image)) {
            $saveData['image_path'] = $image['path'];
        }

        if (!empty($request->file('image'))) {
            $imageType = ImageType::query()
                ->where('slug', ImageType::MAIN)
                ->first();

            $character->image()->create([
                'path' => $this->uploadImage($request->file('image'), $saveData['slug']),
                'image_type_id' => $imageType['id']
            ]);
        }

        $data = [
            'character' => $character
        ];

        return $this->successResponse($data, 'Персонаж создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function show($id)
    {
        $character = Character::query()
            ->where('id', $id)
            ->first();

        $data = [
            'character' => $character
        ];

        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(CharacterUpdateRequest $request, $id)
    {
        if (empty($id)) {
            return $this->errorResponse(400, 'Bad request.');
        }

        $image = null;

        if (!empty($request->image)) {
            $image = Image::query()->create([
                'path' => $this->uploadImage($request->image)
            ]);
        }

        $saveData = $request->validated();

        if (!empty($image)) {
            $saveData['image'] = $image;
        }

        Character::query()
            ->where('id', $id)
            ->update($saveData);

        return $this->successResponse(null, 'Данные персонажа обновлены.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function destroy($id)
    {
        //
    }

    public function create()
    {
        $stars = Star::all();
        $weaponTypes = WeaponType::all();
        $elements = Element::all();

        $data = [
            'stars' => $stars,
            'weapon_types' => $weaponTypes,
            'elements' => $elements
        ];

        return $this->successResponse($data);
    }
}
