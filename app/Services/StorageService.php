<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService extends Storage
{
    const IMG_STORAGE_DISK = 'public';


    public static function getAllImagesByDir(string $dir_path): array
    {
        $disk = Storage::disk(self::IMG_STORAGE_DISK);
        $imgDir = sprintf($dir_path);
        $imgList = [];
        if ($disk->exists($imgDir)) {
            $dirs = $disk->directories($imgDir);

            foreach ($dirs as $dir) {
                $files = $disk->files($dir);
                if (count($files) > 0) {
                    foreach ($files as $file) {
                        $imgList[$dir][] = Storage::url($file);
                    }
                }
            }
        }
        return $imgList;
    }

    public static function saveProduct(int $id, string $type = 'original', $file): string {
        $disk = Storage::disk(self::IMG_STORAGE_DISK);
        $productImagePath = "images/products/{$id}/{$type}";
        if (!$disk->exists($productImagePath)) {
            $disk->makeDirectory($productImagePath);
        }
        $fileName = time() . "_{$id}";
        $disk->putFileAs($productImagePath, $file, $fileName . '.' . $file->extension());
        return $fileName;
    }
}
