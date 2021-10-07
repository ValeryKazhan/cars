<?php

namespace App\Http\Controllers;

use App\Filters\BrandFilter;
use App\Http\Requests\BrandNameUpdateRequest;
use App\Http\Requests\BrandStoreRequest;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    public function index(BrandFilter $brandFilter): JsonResponse
    {
        return response()->json(Brand::query()->filter($brandFilter)->paginate(self::ITEMS_PER_PAGE));
    }

    public function store(BrandStoreRequest $request): JsonResponse
    {
        return response()->json(Brand::create($request->all()));
    }

    public function update(Brand $brand, BrandNameUpdateRequest $request): JsonResponse
    {
        $brand->update(['name' => $request->get('name')]);
        return response()->json($brand);
    }

    public function destroy (Brand $brand): ?bool
    {
        return $brand->delete();
    }

}
