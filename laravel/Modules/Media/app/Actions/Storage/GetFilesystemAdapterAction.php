<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Storage;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;

/**
 * Restituisce il disco come FilesystemAdapter (mimeType(), url(), temporaryUrl()).
 *
 * `Storage::disk()` e' tipizzato sul contratto `Filesystem`, che non dichiara questi metodi.
 */
class GetFilesystemAdapterAction
{
    use QueueableAction;

    public function execute(string $disk): FilesystemAdapter
    {
        $filesystem = Storage::disk($disk);

        if (! $filesystem instanceof FilesystemAdapter) {
            throw new RuntimeException("Il disco [{$disk}] non e' un FilesystemAdapter.");
        }

        return $filesystem;
    }
}
