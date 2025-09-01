<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product_id = $this->id;

        $categories = DB::table('product_categories')->join(
            'categories_of_products',
            'categories_of_products.product_category_id',
            '=',
            'product_categories.id'
        )->where('categories_of_products.product_id', $product_id)->select(
            [
                'product_categories.id',
            ]
        )->get()->pluck('id')->toArray();

        return [
            'id' => $product_id,
            'name' => $this->name,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'ccal' => $this->ccal,
            'img' => $this->img,
            'meas_value' => $this->meas_value,
            'chpu' => $this->chpu,
            'categories' => array_values($categories),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'measure_type' => $this->measure_type
        ];
    }
}
