<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Stores every source image privately, then serves a WebP copy when GD supports
 * the image. If WebP conversion is unavailable, the original is served instead.
 */
class OptimizedImageUpload
{
    public function store(UploadedFile $file, string $publicDirectory = 'uploads'): string
    {
        $publicDirectory = trim(str_replace('\\', '/', $publicDirectory), '/');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $basename = Str::uuid()->toString();
        $archiveDirectory = storage_path('app/private/upload-originals/' . now()->format('Y/m'));

        File::ensureDirectoryExists($archiveDirectory);
        $originalPath = $archiveDirectory . DIRECTORY_SEPARATOR . $basename . '.' . $extension;
        $file->move($archiveDirectory, basename($originalPath));

        $publicPath = public_path($publicDirectory);
        File::ensureDirectoryExists($publicPath);
        $webpPath = $publicPath . DIRECTORY_SEPARATOR . $basename . '.webp';

        if ($this->convertToWebp($originalPath, $webpPath)) {
            return $publicDirectory . '/' . $basename . '.webp';
        }

        // A host without GD still receives a working upload. The source remains
        // archived privately and can be converted later once GD is enabled.
        $fallbackPath = $publicPath . DIRECTORY_SEPARATOR . $basename . '.' . $extension;
        File::copy($originalPath, $fallbackPath);

        return $publicDirectory . '/' . $basename . '.' . $extension;
    }

    private function convertToWebp(string $sourcePath, string $destinationPath): bool
    {
        if (!function_exists('imagewebp')) {
            return false;
        }

        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }

        $image = match ($imageInfo['mime'] ?? '') {
            'image/jpeg' => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($sourcePath) : false,
            'image/png' => function_exists('imagecreatefrompng') ? @imagecreatefrompng($sourcePath) : false,
            'image/gif' => function_exists('imagecreatefromgif') ? @imagecreatefromgif($sourcePath) : false,
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false,
            default => false,
        };

        if (!$image) {
            return false;
        }

        if (in_array($imageInfo['mime'], ['image/png', 'image/webp'], true)) {
            imagepalettetotruecolor($image);
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        $converted = imagewebp($image, $destinationPath, 82);
        imagedestroy($image);

        return $converted && File::exists($destinationPath);
    }
}
