<?php

namespace App\Models\Services;

class FileService
{
    public const IMAGE_UPLOAD_ERR = 'Something went wrong with the image upload';

    public function save(array $file): string|false
    {
        $tmpName = $file['tmp_name'];

        $originalName = $file['name'];
        $trimmedName = str_replace(' ', '_', $originalName);

        $finalName = uniqid() . $trimmedName;
        $finalPath = IMAGE_UPLOAD_DIR . '/' . $finalName;

        if (
            move_uploaded_file($tmpName, ROOT_DIR . '/public/' . $finalPath)
        ) {
            return $finalPath;
        }

        return false;
    }

    public function delete(string $path): void
    {
        unlink(ROOT_DIR . '/public' . $path);
    }
}
