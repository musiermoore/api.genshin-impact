<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CharacteristicStoreRequest;
use App\Models\Characteristic;
use App\Models\CharacteristicType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CharacteristicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $characteristics = Characteristic::with('characteristicType')
            ->orderBy('characteristic_type_id')
            ->orderBy('id')
            ->get();

        $data = [
            'characteristics' => $characteristics
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
        $characteristicTypes = CharacteristicType::all();

        $data = [
            'characteristic_types' => $characteristicTypes
        ];

        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CharacteristicStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharacteristicStoreRequest $request)
    {
        $saveData = $request->validated();

        $saveData['slug'] = !empty($saveData['slug'])
            ? Str::slug($saveData['slug'])
            : Str::slug($saveData['name']);

        $characteristic = Characteristic::query()->create($saveData);

        $data = [
            'characteristic' => $characteristic
        ];

        return $this->successResponse($data, 'Персонаж создан.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
