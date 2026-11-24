<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/build-language-url-action.md
<<<<<<< .merge_file_BGoOwN
 *
=======
>>>>>>> .merge_file_i5HkRO
 * @contract docs/contracts/build-language-url-action.md
 */
class BuildLanguageUrlAction
{
    use QueueableAction;

    public function execute(): string
    {
        return '?';
    }
}
