<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Media\Actions\Video;

use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-video-duration-action.md
 *
 * @contract docs/contracts/get-video-duration-action.md
 */
class GetVideoDurationAction
{
    use QueueableAction;

    public function execute(string $disk, string $file): ?int
    {
        if (! Storage::disk($disk)->exists($file)) {
            return null;
        } // returns an int

        return FFMpeg::fromDisk($disk)->open($file)->getDurationInSeconds();
    }
}
