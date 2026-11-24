<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ArtisanService::sessionClear().
<<<<<<< .merge_file_D7zxbv
 *
 * @see docs/contracts/clear-artisan-session-files-action.md
 *
=======
 * @see docs/contracts/clear-artisan-session-files-action.md
>>>>>>> .merge_file_99rc04
 * @contract docs/contracts/clear-artisan-session-files-action.md
 */
class ClearArtisanSessionFilesAction
{
    use QueueableAction;

    public function execute(): string
    {
        $files = File::files(storage_path('framework/sessions'));

        foreach ($files as $file) {
            if ($file->getExtension() === '' && $file->getRealPath() !== false) {
                File::delete($file->getRealPath());
            }
        }

        return 'Session cleared! ('.\count($files).' Files )';
    }
}
