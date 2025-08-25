<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\ProductCategory;
use App\Services\ProductCategoriesService;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    private ProductCategoriesService $service;
    public function __construct(ProductCategoriesService $service) {
        $this->service = $service;
    }

    public function save(SaveProductCategoryRequest $request) {
        return $this->service->save($request->all());
    }

    public function all() {
        return ProductCategoryResource::collection(ProductCategory::all());
    }

    public function delete(int $id) {
        return ProductCategory::findOrFail($id)->delete();
    }
}
