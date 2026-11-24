<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/create-directory-for-filename-action.md
<<<<<<< .merge_file_qD8A0u
 *
=======
>>>>>>> .merge_file_NHthUf
 * @contract docs/contracts/create-directory-for-filename-action.md
 */
class CreateDirectoryForFilenameAction
{
    use QueueableAction;

    public function execute(string $filename): void
    {
        if (! File::exists(\dirname($filename))) {
            File::makeDirectory(\dirname($filename), 0o755, true, true);
        }
    }
}
