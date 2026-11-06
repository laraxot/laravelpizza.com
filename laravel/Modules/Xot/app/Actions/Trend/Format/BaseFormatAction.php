<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Format;

use Spatie\QueueableAction\QueueableAction;

abstract class BaseFormatAction
{
    use QueueableAction;

    abstract public function execute(string $column, string $interval): string;
}
