<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ArtisanService::sessionClear().
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
