<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if ($request->get('showOnlyNotFillProperties') == 1) {
            $productQuery = Product::where('meas_value', 0);
        }

        if ($search = $request->get('search')) {
            if (isset($productQuery)) {
                $productQuery = $productQuery->where('name', 'LIKE', '%' . $search . '%');
            } else {
                $productQuery = Product::where('name', 'LIKE', '%' . $search . '%');
            }
        }
        return [
            'list' => $this->resource['list'],
            'count' => isset($productQuery) ? $productQuery->count() : Product::count()
        ];
    }
}
