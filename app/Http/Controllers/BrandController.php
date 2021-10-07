<?php

namespace App\Http\Controllers;

use App\Filters\BrandFilter;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    public function index(BrandFilter $brandFilter): \Illuminate\Http\JsonResponse
    {
        return response()->json(Brand::query()->filter($brandFilter)->paginate(self::ITEMS_PER_PAGE));
    }

    public function store(BrandStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(Brand::create($request->all()));
    }

    public function update(Brand $brand, BrandUpdateRequest $request)
    {

        $brand->update(['name' => $request->get('name')]);
        $brand = $brand->fresh();
        dd($brand);
        return response()->json([
            'id' => $brand->id,
            'name' => $brand->name,
            'created_by' => $brand->created_by,
        ]);
    }

    public function destroy (Brand $brand){
        $brand->delete();
    }

}
