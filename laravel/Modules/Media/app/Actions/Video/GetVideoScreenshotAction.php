<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Media\Actions\Video;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-video-screenshot-action.md
 * @contract docs/contracts/get-video-screenshot-action.md
 */
class GetVideoScreenshotAction
{
    use QueueableAction;

    /**
     * The number of seconds to wait before retrying the action.
     *
     * @var array<int>|int
     */
    public $backoff = 3;
}
