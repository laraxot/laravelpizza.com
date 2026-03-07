<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\ModelClass;

use Spatie\QueueableAction\QueueableAction;

/**
 * Placeholder action used by CopyFromLastYearButton.
 *
 * The concrete copy strategy depends on module/domain rules, so this action is
 * intentionally no-op until a module provides its own implementation.
 */
class CopyFromLastYearAction
{
    use QueueableAction;

    public function execute(string $modelClass, string $fieldName, ?string $year): void
    {
    }
}
