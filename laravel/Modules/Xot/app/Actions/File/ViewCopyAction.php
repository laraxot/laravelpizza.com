<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Spatie\QueueableAction\QueueableAction;

class ViewCopyAction
{
    use QueueableAction;

    public function execute(string $source, string $destination): void
    {
        $sourcePath = app(ViewPathAction::class)->execute($source);
        $destPath = app(ViewPathAction::class)->execute($destination);

        // Ensure destination directory exists
        $destDir = dirname($destPath);
        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        // Copy the file if source exists
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destPath);
        }
    }
}
