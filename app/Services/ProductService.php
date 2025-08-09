<?php

namespace App\Services;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\Exception;

class ProductService
{
    const PRODUCT_IMG_PATH = 'images/products/%s/';

    public function getProductList($page = 1, Request $request)
    {
        $take = $request->get('take') ?? 10;

        $productQuery = Product::select('*');

        if ($request->get('showOnlyNotFillProperties') == 1) {
            $productQuery = $productQuery->where('meas_value', 0);
        }

        if ($search = $request->get('search')) {
            $productQuery = $productQuery->where('name', 'LIKE', '%' . $search . '%');
        }

        $productQuery = $productQuery->skip(($page - 1) * $take)->take($take);
        $product = $productQuery->get()->map(function ($item, $key) {
            $item['img'] = StorageService::getAllImagesByDir(sprintf(self::PRODUCT_IMG_PATH, $item->id));
            switch ($item['meas_value']) {
                case 0:
                    $item['measure_type'] = '-';
                    break;
                case 1:
                    $item['measure_type'] = 'г';
                    break;
                case 2:
                    $item['measure_type'] = 'мл';
                    break;
            }
            return $item;
        });


        return $product;
    }

    public function getById($id)
    {
        $product = Product::findOrFail($id);
        $product->img = StorageService::getAllImagesByDir(sprintf(self::PRODUCT_IMG_PATH, $product->id));
        return $product;
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
            $filename = StorageService::saveProduct($product->id, 'original', $request->file('img'));
            $product->img = ['original' => $filename];
        }
        return $product;
    }

    public function updateProduct(int $id, UpdateProductRequest $request)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'proteins', 'fats', 'carbs', 'ccal', 'meas_value', 'chpu']));
        $product->refresh();
        if ($request->file('img')) {
            $filename = StorageService::saveProduct($product->id, 'original', $request->file('img'));
            $product->img = ['original' => $filename];
        }

        return $product;
    }

    public function delete(int $id)
    {
        return Product::findOrFail($id)->delete();
    }
}
