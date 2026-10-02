<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadsImage
{
    /**
     * Upload a new image and optionally delete the old one.
     *
     * @param UploadedFile $file The new uploaded file.
     * @param string $path The directory path where the file should be stored.
     * @param string|null $oldImage The path of the old image to delete.
     * @param string $disk The storage disk to use (default: 'public').
     * @return string The path of the newly stored file.
     */
    public function uploadImage(UploadedFile $file, string $path, ?string $oldImage = null, string $disk = 'public'): string
    {
        if ($oldImage && Storage::disk($disk)->exists($oldImage)) {
            Storage::disk($disk)->delete($oldImage);
        }

        return $file->store($path, $disk);
    }

    /**
     * Delete an image from storage.
     *
     * @param string|null $imagePath The path of the image to delete.
     * @param string $disk The storage disk.
     */
    public function deleteImage(?string $imagePath, string $disk = 'public'): void
    {
        if ($imagePath && Storage::disk($disk)->exists($imagePath)) {
            Storage::disk($disk)->delete($imagePath);
        }
    }
}
