<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Image;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\ImageManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueueableAction\QueueableAction;

/**
 * Re-encodes a stored JPEG or PNG original without its metadata (EXIF, GPS position, camera, XMP, text chunks).
 *
 * Intervention Image (already installed, GD driver) applies the EXIF orientation first, so the photo keeps its rotation, then
 * writes a new file that carries pixels only. Any other mime type (PDF, ...) is left untouched. Updates `size` on the media row.
 */
final class StripImageMetadataAction
{
    use QueueableAction;

    private const int JPEG_QUALITY = 90;

    public function execute(Media $media): void
    {
        $encoder = match ($media->mime_type) {
            'image/jpeg' => new JpegEncoder(quality: self::JPEG_QUALITY, strip: true),
            'image/png' => new PngEncoder(strip: true),
            default => null,
        };
        if ($encoder === null) {
            return;
        }

        $disk = Storage::disk($media->disk);
        $path = $media->getPathRelativeToRoot();
        $original = $disk->get($path);
        if ($original === null) {
            return;
        }

        $clean = (string) (new ImageManager(new GdDriver))->decodeBinary($original)->encode($encoder);
        $disk->put($path, $clean);
        $media->size = strlen($clean);
        $media->save();
    }
}
