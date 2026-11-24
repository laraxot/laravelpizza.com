<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Media\Actions;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/attach-media-action.md
 * @contract docs/contracts/attach-media-action.md
 */
class AttachMediaAction
{
    use QueueableAction;
}
