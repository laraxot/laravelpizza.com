<?php

declare(strict_types=1);

namespace Modules\Media\Datas;

use Spatie\LaravelData\Data;

/**
 * Single attachment entry to be persisted into a media collection.
 *
 * Replaces the parallel-array pattern (`list<string> $attachments` +
 * `array<string,string|null> $data` keyed by attachment name) with one
 * typed pair per attachment.
 */
class AttachmentToSaveData extends Data
{
    public function __construct(
        public string $name,
        public ?string $path = null,
    ) {}
}
