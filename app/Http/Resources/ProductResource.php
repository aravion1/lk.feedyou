<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'ccal' => $this->ccal,
            'img' => $this->img,
            'meas_value' => $this->meas_value,
            'chpu' => $this->chpu,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'measure_type' => $this->measure_type
        ];
    }
}
