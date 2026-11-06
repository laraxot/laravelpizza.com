<?php

declare(strict_types=1);

namespace Modules\Media\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\QueueableAction\QueueableAction;
use UnexpectedValueException;

use function Safe\file_put_contents;
use function Safe\tempnam;
use function Safe\unlink;

class SaveAttachmentsAction
{
    use QueueableAction;

    /**
     * Save attachments to media library.
     *
     * @param  array<int, string>  $attachments
     * @param  array<string, mixed>  $data
     */
    public function execute(HasMedia $record, array $attachments, array $data, string $disk = 'attachments'): void
    {
        $dataAttachments = [];
        $storage = Storage::disk($disk);

        foreach ($attachments as $attachment) {
            if (! array_key_exists($attachment, $data)) {
                continue;
            }

            $path = $data[$attachment];
            if (! is_string($path)) {
                throw new UnexpectedValueException("Attachment [{$attachment}] must resolve to a string path.");
            }

            if ($path === '' || ! $storage->exists($path)) {
                continue;
            }

            $fileContent = $storage->get($path);
            if (! is_string($fileContent)) {
                throw new UnexpectedValueException("Attachment [{$attachment}] could not be read as a string.");
            }

            $tempPath = tempnam(storage_path('framework/cache'), 'media_');

            try {
                file_put_contents($tempPath, $fileContent);

                $media = $record->addMedia($tempPath)
                    ->usingFileName(basename($path))
                    ->toMediaCollection($attachment, $disk);

                $dataAttachments[$attachment] = $media->getPathRelativeToRoot();
            } finally {
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
            }
        }

        if ($dataAttachments !== []) {
            $record->update($dataAttachments);
        }
    }
}
