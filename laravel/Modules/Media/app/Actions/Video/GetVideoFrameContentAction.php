<?php

/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

declare(strict_types=1);

namespace Modules\Media\Actions\Video;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class GetVideoFrameContentAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $disk_mp4, string $file_mp4, int $time): ?string
    {
        if (! Storage::disk($disk_mp4)->exists($file_mp4)) {
            return '';
        }

        $seconds = 3600;

        $cache_key = Str::slug($disk_mp4.' '.$file_mp4.' '.$time.' 1');

        return Cache::store('file')->remember($cache_key, $seconds, static function () use (
            $disk_mp4,
            $file_mp4,
            $time,
        ) {
            try {
                return FFMpeg::fromDisk($disk_mp4)
                    ->open($file_mp4)
                    ->getFrameFromSeconds($time)
                    ->export()
                    ->getFrameContents();
            } catch (Exception) {
                return Storage::disk('public_html')->get('img/video_not_exists.jpg');
            }
        });
    }
}
