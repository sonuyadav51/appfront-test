<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class FileUploadService
{
    

    public function upload(UploadedFile $file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/products';

        $file->move(public_path($path), $filename);

        return "$path/$filename";
    }
}
