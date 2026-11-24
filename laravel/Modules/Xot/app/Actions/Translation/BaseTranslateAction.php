<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Translation;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/base-translate-action.md
<<<<<<< .merge_file_IG8OOj
 *
=======
>>>>>>> .merge_file_WMEHjm
 * @contract docs/contracts/base-translate-action.md
 */
abstract class BaseTranslateAction
{
    use QueueableAction;

    abstract public function execute(string $text, string $from, string $to): string;
}
