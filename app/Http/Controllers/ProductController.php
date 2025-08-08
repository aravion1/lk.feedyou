<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function productList(int $page = 1)
    {
        $collection = collect(['list' => ProductResource::collection($this->service->getProductList($page))]);
        return new ProductListResource($collection);
    }

    public function productById(int $id)
    {
        return new ProductResource($this->service->getById($id));
    }

    public function productByChpu(string $chpu)
    {
        return new ProductResource(Product::where('chpu', $chpu)->firstOrFail());
    }

    public function create(CreateProductRequest $request) {
        return new ProductResource($this->service->createProduct($request));
    }

    public function updateProduct(int $id, UpdateProductRequest $request) {
        return new ProductResource($this->service->updateProduct($id, $request));
    }

    public function delete(int $id) {
        return $this->service->delete($id);
    }

    public function deleteImage(Request $request) {
        $path = $request->get('path');
        $path = str_replace('/storage/', '/', $path);

        return Storage::disk('public')->delete($path);
    }
}
