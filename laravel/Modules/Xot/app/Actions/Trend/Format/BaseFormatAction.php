<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Format;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/base-format-action.md
<<<<<<< .merge_file_Z5eZIW
 *
=======
>>>>>>> .merge_file_yE2Wxc
 * @contract docs/contracts/base-format-action.md
 */
abstract class BaseFormatAction
{
    use QueueableAction;

    abstract public function execute(string $column, string $interval): string;
}
