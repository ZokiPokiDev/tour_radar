<?php

namespace App\Factories;

use Illuminate\Support\Facades\Storage;

class TourFileStore
{
    public const STORAGE_PATH = 'tour/';

    public function store($content, string $fileName, string $fileExtension = '.json'): array
    {
        $path = self::STORAGE_PATH . $fileName . $fileExtension;

        if (Storage::disk('local')->exists($path)) {
            return ['exist' => true, 'path' => $path];
        }

        Storage::disk('local')->put($path, json_encode($content));

        return ['exist' => false, 'path' => $path];
    }
}
