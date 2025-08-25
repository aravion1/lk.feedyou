<?php

namespace App\Services;

use App\Models\ProductCategory;

class ProductCategoriesService {
    public function save(array $data) {
        $fields = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null
        ];
        if (isset($data['id'])) {
            return ProductCategory::findOrFail($data['id'])->update($fields);
        }

        return ProductCategory::create($fields);
    }
}
