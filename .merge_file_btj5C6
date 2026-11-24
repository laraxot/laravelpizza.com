<?php

/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

declare(strict_types=1);

namespace Modules\Media\Actions\Video;

use FFMpeg\Format\Video\X264;
use Modules\Media\Actions\Storage\GetFilesystemAdapterAction;
use Modules\Media\Actions\Ffmpeg\ResolveMediaExporterAction;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class ConvertVideoAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $disk_mp4, string $file_mp4, string $file_new): string
    {
        $media = FFMpeg::fromDisk($disk_mp4);

        $openedMedia = $media->open($file_mp4);

        $exportedMedia = $openedMedia->export();

        $format = new X264;
        $format->setKiloBitrate(1000);

        $formattedMedia = app(ResolveMediaExporterAction::class)->execute(
            $exportedMedia->toDisk($disk_mp4)
        )->inFormat($format);
        $formattedMedia->save($file_new);

        return app(GetFilesystemAdapterAction::class)->execute($disk_mp4)->url($file_new);
    }
}
