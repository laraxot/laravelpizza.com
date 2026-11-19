<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Vision;

use Modules\AI\Exceptions\AiRequestException;
use Safe\Exceptions\FileinfoException;
use Safe\Exceptions\FilesystemException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\file_get_contents;
use function Safe\mime_content_type;

/**
 * Immagine su disco -> data URI base64 (`data:image/jpeg;base64,...`), il formato che le API compatibili
 * OpenAI accettano per immagini private. Solo i tipi che i modelli leggono: png, jpeg, webp, gif.
 */
class ImageDataUriAction
{
    use QueueableAction;

    public const array MIME_TYPES = ['image/png', 'image/jpeg', 'image/webp', 'image/gif'];

    public function execute(string $path): string
    {
        if (! is_file($path) || ! is_readable($path)) {
            throw new AiRequestException('Immagine non leggibile: '.basename($path));
        }

        try {
            $mime = mime_content_type($path);
            $bytes = file_get_contents($path);
        } catch (FileinfoException|FilesystemException $e) {
            throw new AiRequestException('Immagine non leggibile: '.basename($path), previous: $e);
        }

        if (! in_array($mime, self::MIME_TYPES, true)) {
            throw new AiRequestException('Formato immagine non supportato: '.$mime);
        }

        if ($bytes === '') {
            throw new AiRequestException('Immagine vuota: '.basename($path));
        }

        return 'data:'.$mime.';base64,'.base64_encode($bytes);
    }
}
