<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Upload;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Largest file, in bytes, that a Livewire temporary upload can really carry in the running web request.
 *
 * Three limits stack on one upload and the smallest wins: PHP (`upload_max_filesize` and `post_max_size`), the Livewire rule
 * (`temporary_file_upload.rules`, 12 MB by default) and the field's own `maxSize()`. A field that advertises more than PHP accepts
 * fails with a 422 `validation.uploaded` before the form ever sees the file. Evaluate this inside the web request: the CLI reads a
 * different `php.ini` than FPM or the built-in server that receives the upload.
 *
 * Nginx `client_max_body_size` is not visible from PHP; the browser still needs to send small files (see the camera upload ADR).
 */
final class GetEffectiveUploadLimitAction
{
    use QueueableAction;

    /** The file travels in a multipart body with boundaries and form fields: leave a tenth of the PHP limit free. */
    private const float MULTIPART_HEADROOM = 0.9;

    /** Livewire applies `max:12288` (kilobytes) when `temporary_file_upload.rules` is null. */
    private const int LIVEWIRE_DEFAULT_MAX_KB = 12288;

    public function execute(?int $fieldMaxKb = null): int
    {
        $limits = [
            (int) floor(UploadedFile::getMaxFilesize() * self::MULTIPART_HEADROOM),
            $this->getLivewireMaxKb() * 1024,
        ];

        if ($fieldMaxKb !== null) {
            $limits[] = $fieldMaxKb * 1024;
        }

        return min($limits);
    }

    private function getLivewireMaxKb(): int
    {
        $rules = config('livewire.temporary_file_upload.rules');
        $rules = is_string($rules) ? explode('|', $rules) : $rules;

        foreach (is_array($rules) ? $rules : [] as $rule) {
            if (is_string($rule) && str_starts_with($rule, 'max:')) {
                return (int) substr($rule, 4);
            }
        }

        return self::LIVEWIRE_DEFAULT_MAX_KB;
    }
}
