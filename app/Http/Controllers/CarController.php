<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    public function store(Request $request) : JsonResponse
    {
        $attributes = $request->validate([
            'brand_id' => ['required', Rule::exists('brands', 'id')],
            'name' => ['required', 'max:25', Rule::unique('cars', 'name')]
        ]);
        return Car::create($attributes)->toJson();
    }

    public function update(Car $car, Request $request): JsonResponse
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:25', Rule::unique('cars', 'name')->ignore($car->id)]
        ]);
        return $car->update([$attributes])->toJson();
    }

    public function destroy (Car $car){
        $car->delete();
    }

}
