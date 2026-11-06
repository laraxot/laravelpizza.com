<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Spatie\LaravelData\Data;

/**
 * La coda letta di un file di log.
 *
 * `size` e' la dimensione dell'intero file, `bytesRead` quanti byte sono stati letti,
 * `truncated` dice se il file e' piu' grande della parte letta.
 */
final class LogTailData extends Data
{
    public function __construct(
        public readonly string $content,
        public readonly int $size,
        public readonly int $bytesRead,
        public readonly bool $truncated,
    ) {}
}
