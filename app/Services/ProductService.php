<?php

namespace App\Services;

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
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
                $disk = Storage::disk('public');
                $imgDir = sprintf(self::PRODUCT_IMG_PATH, $item->id);
                if ($disk->exists($imgDir)) {
                    $dirs = $disk->directories($imgDir);
                    $imgList = [];
                    foreach ($dirs as $dir) {
                        $files = $disk->files($dir);
                        if (count($files) > 0) {
                            $imgList[$dir] = $files;
                        }
                    }
                    $item['img_list'] = $imgList;
                } else {
                    $item['img_list'] = [];
                }
                return $item;
            });
    }

    public function createProduct(CreateProductRequest $request)
    {
        try {
            $product = Product::create(
                $request->only(
                    'name',
                    'proteins',
                    'fats',
                    'carbs',
                    'ccal',
                    'meas_value',
                    'chpu'
                )
            );

            if ($product) {
//                $img_list = $p
            }
        } catch (Exception $err) {

        }

    }
}
