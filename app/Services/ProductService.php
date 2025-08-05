<?php

namespace App\Services;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\Exception;

class ProductService
{
    const PRODUCT_IMG_PATH = 'images/products/%s/';
    const COUNT_VIEW_LIST_ITEMS = 10;

    public function getProductList($page = 1)
    {
        return Product::take(self::COUNT_VIEW_LIST_ITEMS)
            ->skip(($page - 1) * self::COUNT_VIEW_LIST_ITEMS)
            ->get()->map(function ($item, $key) {
                $item['img_list'] = StorageService::getAllImagesByDir(sprintf(self::PRODUCT_IMG_PATH, $item->id));
                return $item;
            });
    }

    public function createProduct(CreateProductRequest $request)
    {
        $data = $request->only(
            'name',
            'proteins',
            'fats',
            'carbs',
            'ccal',
            'meas_value',
            'chpu'
        );

        if (empty($data['chpu'])) {
            $data['chpu'] = Str::slug($data['name']);
        }

        $product = Product::create(
            $data
        );

        if ($product) {
            $filename = StorageService::saveProduct($product->id, 'original', $request->file('img_list'));
            $product->img_list = ['original' => $filename];
        }
        return $product;
    }

    public function updateProduct(int $id, UpdateProductRequest $request)
    {
        $product = Product::findOrFail($id)->update(
            $request->only(['name', 'proteins', 'fats', 'carbs', 'ccal', 'meas_value', 'chpu'])
        )->refresh();

        $filename = StorageService::saveProduct($product->id, 'original', $request->file('img_list'));
        $product->img_list = ['original' => $filename];

        return $product;
    }

    public function delete(int $id) {
        return Product::findOrFail($id)->delete();
    }
}
