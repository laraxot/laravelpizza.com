<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ArtisanService::debugbarClear().
<<<<<<< .merge_file_Ig9U8V
 *
 * @see docs/contracts/clear-artisan-debugbar-files-action.md
 *
=======
 * @see docs/contracts/clear-artisan-debugbar-files-action.md
>>>>>>> .merge_file_GhyRA5
 * @contract docs/contracts/clear-artisan-debugbar-files-action.md
 */
class ClearArtisanDebugbarFilesAction
{
    use QueueableAction;

    public function execute(): string
    {
        $files = File::files(storage_path('debugbar'));

        foreach ($files as $file) {
            if ($file->getExtension() === 'json' && $file->getRealPath() !== false) {
                File::delete($file->getRealPath());
            }
        }

        return 'Debugbar Storage cleared! ('.\count($files).' Files )';
    }
}
