<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class UserService
{

    public function getOptimizedImageData(UploadedFile $file, string $method = 'fit', int $width = 70, int $height = 70)
    {
        \Tinify\setKey("N1yrjlZt5W6pMwCQSQY5SmBysbgR6cxV");
        $source = \Tinify\fromFile($file->path());
        $resized = $source->resize([
          'method' => $method,
          'width' => $width,
          'height' => $height
        ]);

        return $resized->toBuffer();
    }
}