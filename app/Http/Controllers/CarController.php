<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarNameUpdateRequest;
use App\Http\Requests\CarStoreRequest;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function store(CarStoreRequest $request) : JsonResponse
    {
        return response()->json(Car::create($request->all()));
    }

    public function update(Car $car, CarNameUpdateRequest $request): JsonResponse
    {
        $car->update(['name' => $request->get('name')]);
        return response()->json($car);
    }

    public function destroy (Car $car){
        return $car->delete();
    }

}
