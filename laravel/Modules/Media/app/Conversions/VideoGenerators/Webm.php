<?php

declare(strict_types=1);

namespace Modules\Media\Conversions\VideoGenerators;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Conversions\ImageGenerators\ImageGenerator;

class Webm extends ImageGenerator
{
    public function convert(string $file, ?Conversion $conversion = null): string
    {
        // Generatore mai completato e non registrato in config/media-library.php ('image_generators').
        throw new \LogicException('Webm::convert() non implementato');
    }

    public function requirementsAreInstalled(): bool
    {
        /*
         * if (! function_exists('imagecreatefromwebp')) {
         * return false;
         * }
         *
         * if (! function_exists('imagepng')) {
         * return false;
         * }
         *
         * if (! function_exists('imagedestroy')) {
         * return false;
         * }
         */
        return true;
    }

    /**
     * @return Collection<int, string>
     */
    public function supportedExtensions(): Collection
    {
        return collect([
            // 'webm',
            // 'mov',
            'mp4',
        ]);
    }

    /**
     * @return Collection<int, string>
     */
    public function supportedMimeTypes(): Collection
    {
        return collect([
            // 'video/webm',
            'video/mpeg',
            'video/mp4',
            // 'video/quicktime'
        ]);
    }
}
