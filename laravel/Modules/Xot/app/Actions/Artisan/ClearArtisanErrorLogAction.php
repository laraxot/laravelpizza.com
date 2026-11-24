<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ArtisanService::errorClear().
 *
 * @see docs/contracts/clear-artisan-error-log-action.md
 *
 * @contract docs/contracts/clear-artisan-error-log-action.md
 */
class ClearArtisanErrorLogAction
{
    use QueueableAction;

    public function execute(): string
    {
        $files = File::files(storage_path('logs'));

        foreach ($files as $file) {
            if ($file->getExtension() === 'log' && $file->getRealPath() !== false) {
                File::delete($file->getRealPath());
            }
        }

        return '<pre>laravel.log cleared !</pre> ('.\count($files).' Files )';
    }
}
