<?php

namespace App\Services\Parent;

use Illuminate\Support\Facades\File;
use JetBrains\PhpStorm\ArrayShape;

class UsageService
{
    #[ArrayShape(['images' => 'string', 'sound' => 'string'])]
 public function get(): array
 {
     return [
         'images' => $this->imageFolderSize(),
         'sound' => $this->soundFolderSize(),
     ];
 }

    private function imageFolderSize(): string
    {
        $fileSize = 0;
        foreach (File::allFiles(storage_path('books')) as $file) {
            $fileSize += $file->getSize();
        }

        return number_format($fileSize / 1048576, 2);
    }

    private function soundFolderSize(): string
    {
        $fileSize = 0;
        foreach (File::allFiles(storage_path('sound')) as $file) {
            $fileSize += $file->getSize();
        }

        return number_format($fileSize / 1048576, 2);
    }
}
