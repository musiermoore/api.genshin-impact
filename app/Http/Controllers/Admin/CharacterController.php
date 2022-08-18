<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CharacterStoreRequest;
use App\Http\Requests\Admin\CharacterUpdateRequest;
use App\Http\Traits\ImageUpload;
use App\Models\Character;
use App\Models\Characteristic;
use App\Models\Element;
use App\Models\Image;
use App\Models\ImageType;
use App\Models\Rarity;
use App\Models\WeaponType;
use Illuminate\Support\Facades\Storage;
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
            ->with('images.imageType', 'element')
            ->orderBy('name')
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
                'path' => $this->uploadImage($request->file('image'), 'characters', $saveData['slug']),
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
        $rarities = Rarity::all();
        $weaponTypes = WeaponType::all();
        $elements = Element::all();

        $character = Character::query()
            ->with(
                'element',
                'rarity',
                'weaponType',
                'image',
                'characterLevels.level',
                'characterLevels.ascension'
            )
            ->where('id', $id)
            ->first();

        if (empty($character)) {
            return $this->errorResponse(404, 'Персонаж не найден.');
        }

        $data = [
            'character' => $character,
            'rarities' => $rarities,
            'weapon_types' => $weaponTypes,
            'elements' => $elements
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

        $character = Character::query()
            ->where('id', $id)
            ->first();

        if (empty($character)) {
            return $this->errorResponse(404, 'Персонаж не найден.');
        }

        $saveData = [
            'rarity_id'      => $request->rarity_id,
            'name'           => $request->name,
            'slug'           => $request->slug ?? null,
            'element_id'     => $request->element_id,
            'weapon_type_id' => $request->weapon_type_id
        ];

        $saveData['slug'] = !empty($saveData['slug'])
            ? Str::slug($saveData['slug'])
            : Str::slug($saveData['name']);

        if (!empty($request->image)) {
            $existingImage = $character->image()
                ->where('imageable_id', $id)
                ->first();

            if (!empty($existingImage)) {
                Storage::delete($existingImage['path']);
            }

            $path = $this->uploadImage($request->image, 'characters', $saveData['slug']);

            $character->image()->updateOrCreate([
                'imageable_id' => $id
            ],[
                'path' => $path
            ]);
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
        if (empty($id)) {
            return $this->errorResponse(400, 'Bad request.');
        }

        $existingImage = Image::query()
            ->where('imageable_id', $id)
            ->where('imageable_type','App\Models\Character')
            ->first();

        if (!empty($existingImage)) {
            Storage::delete($existingImage['path']);
        }

        $existingImage->forceDelete();

        Character::query()
            ->where('id', $id)
            ->forceDelete();

        return $this->successResponse(null, 'Персонаж удален.');
    }

    public function create()
    {
        $rarities = Rarity::all();
        $weaponTypes = WeaponType::all();
        $elements = Element::all();

        $data = [
            'rarities' => $rarities,
            'weapon_types' => $weaponTypes,
            'elements' => $elements
        ];

        return $this->successResponse($data);
    }
}
