<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WeaponStoreRequest;
use App\Http\Requests\Admin\WeaponUpdateRequest;
use App\Http\Requests\WeaponCharacteristicsSaveRequest;
use App\Http\Traits\ImageUpload;
use App\Models\Characteristic;
use App\Models\Image;
use App\Models\ImageType;
use App\Models\Star;
use App\Models\Weapon;
use App\Models\WeaponType;
use App\Services\LevelService;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WeaponController extends Controller
{
    use ResponseTrait, ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $weapons = Weapon::query()
            ->with('images.imageType')
            ->get();

        $data = [
            'weapons' => $weapons
        ];

        return $this->successResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $stars = Star::all();
        $weaponTypes = WeaponType::all();
        $mainCharacteristics = Characteristic::getWeaponCharacteristics();

        $data = [
            'stars' => $stars,
            'weapon_types' => $weaponTypes,
            'main_characteristics' => $mainCharacteristics
        ];

        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WeaponStoreRequest $request)
    {
        $image = null;

        $saveData = $request->validated();

        $saveData['slug'] = !empty($saveData['slug'])
            ? Str::slug($saveData['slug'])
            : Str::slug($saveData['name']);

        $weapon = Weapon::query()->create($saveData);

        if (!empty($image)) {
            $saveData['image_path'] = $image['path'];
        }

        if (!empty($request->file('image'))) {
            $imageType = ImageType::query()
                ->where('slug', ImageType::MAIN)
                ->first();

            $weapon->image()->create([
                'path' => $this->uploadImage($request->file('image'), 'weapons', $saveData['slug']),
                'image_type_id' => $imageType['id']
            ]);
        }

        $data = [
            'weapon' => $weapon
        ];

        return $this->successResponse($data, 'Оружие добавлено.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $stars = Star::all();
        $weaponTypes = WeaponType::all();
        $weaponLevels = (new LevelService())->getWeaponLevelsWithAscensions();
        $mainCharacteristics = Characteristic::getWeaponCharacteristics();

        $weapon = Weapon::query()
            ->with([
                'weaponType',
                'image',
                'characteristics.level',
                'characteristics.ascension',
                'mainCharacteristic'
            ])
            ->where('id', $id)
            ->first();

        if (empty($weapon)) {
            return $this->errorResponse(404, 'Персонаж не найден.');
        }

        $data = [
            'weapon' => $weapon,
            'stars' => $stars,
            'weapon_types' => $weaponTypes,
            'main_characteristics' => $mainCharacteristics,
            'levels' => $weaponLevels
        ];

        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(WeaponUpdateRequest $request, $id)
    {
        if (empty($id)) {
            return $this->errorResponse(400, 'Bad request.');
        }

        $weapon = Weapon::query()
            ->where('id', $id)
            ->first();

        if (empty($weapon)) {
            return $this->errorResponse(404, 'Оружие не найдено.');
        }

        $saveData = $request->validated();

        $saveData['slug'] = !empty($saveData['slug'])
            ? Str::slug($saveData['slug'])
            : Str::slug($saveData['name']);

        if (!empty($request->image)) {
            $existingImage = $weapon->image()
                ->where('imageable_id', $id)
                ->first();

            if (!empty($existingImage)) {
                Storage::delete($existingImage['path']);
            }

            $path = $this->uploadImage($request->image, 'weapons', $saveData['slug']);

            $imageType = ImageType::query()
                ->where('slug', ImageType::MAIN)
                ->first();

            $weapon->image()->updateOrCreate([
                'imageable_id' => $id,
                'image_type_id' => $imageType['id']
            ],[
                'path' => $path
            ]);
        }

        Weapon::query()
            ->where('id', $id)
            ->update($saveData);

        return $this->successResponse(null, 'Данные оружия обновлены.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return $this->errorResponse(400, 'Bad request.');
        }

        $existingImage = Image::query()
            ->where('imageable_id', $id)
            ->where('imageable_type','App\Models\Weapon')
            ->first();

        if (!empty($existingImage)) {
            Storage::delete($existingImage['path']);
        }

        $existingImage->forceDelete();

        Weapon::query()
            ->where('id', $id)
            ->forceDelete();

        return $this->successResponse(null, 'Оружие удалено.');
    }

    public function saveWeaponCharacteristics(WeaponCharacteristicsSaveRequest $request, $id)
    {
        $weapon = Weapon::query()
            ->where('id', $id)
            ->first();

        if (empty($weapon)) {
            return $this->errorResponse(404, 'Оружие не найдено.');
        }

        $data = $request->validated();


        $characteristic = $weapon->characteristics()
            ->updateOrCreate(
                [
                    'weapon_id' => $id,
                    'level_id' => $data['level_id'],
                    'ascension_id' => $data['ascension_id'],
                ],
                $data
            );

        return $characteristic
            ? $this->successResponse(['id' => $id], 'Характеристики оружия сохранены.')
            : $this->errorResponse('401', 'Ошибка сохранения');
    }
}
