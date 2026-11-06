<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseSpatieMediaLibraryFileUpload;

/**
 * Media Library field for photos taken with a phone camera.
 *
 * A phone photo weighs 3-10 MB and the server accepts 2 MB per request: Filament's FilePond shrinks it in the browser
 * before the upload (9,9 MB become about 1,5 MB at 1920 px, EXIF orientation applied; the field uses 2048 px like the public wizard). Opt-in on purpose: on every field
 * the same transform rewrites SVGs, flattens animated GIFs and makes small PNGs heavier (docs/camera-photo-upload-research.md).
 * The field's own calls still override these defaults; server-side validation is unchanged.
 */
class CameraPhotoUpload extends XotBaseSpatieMediaLibraryFileUpload
{
    /** Longest side, in pixels, of a photo after the browser has shrunk it; same value as Media camera-image.js (public wizard). */
    public const int MAX_SIDE = 2048;

    protected function setUp(): void
    {
        parent::setUp();

        $this->automaticallyResizeImagesToWidth((string) self::MAX_SIDE)
            ->automaticallyResizeImagesToHeight((string) self::MAX_SIDE)
            ->automaticallyResizeImagesMode('contain')
            ->automaticallyUpscaleImagesWhenResizing(false);
    }
}
