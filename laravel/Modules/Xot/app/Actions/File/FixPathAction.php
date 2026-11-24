<?php

declare(strict_types=1);
/**
 * moved from fileservice.
 */

namespace Modules\Xot\Actions\File;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/fix-path-action.md
<<<<<<< .merge_file_TcPtr9
 *
=======
>>>>>>> .merge_file_Rn1v1d
 * @contract docs/contracts/fix-path-action.md
 */
class FixPathAction
{
    use QueueableAction;

    public function execute(string $path): string
    {
        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
    }
}
