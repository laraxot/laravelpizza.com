<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

use Spatie\QueueableAction\QueueableAction;

abstract class BaseTranslateAction
{
    use QueueableAction;

    abstract public function execute(string $text, string $from, string $to): string;
}
