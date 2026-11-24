<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Format;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/base-format-action.md
 *
 * @contract docs/contracts/base-format-action.md
 */
abstract class BaseFormatAction
{
    use QueueableAction;

    abstract public function execute(string $column, string $interval): string;
}
