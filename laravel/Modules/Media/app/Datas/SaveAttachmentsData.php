<?php

declare(strict_types=1);

namespace Modules\Media\Datas;

use Spatie\LaravelData\Data;

/**
 * Typed bag of attachments to persist on one disk.
 *
 * `SaveAttachmentsAction::execute()` still takes the legacy parallel arrays:
 * {@see self::fromNamesAndPaths()} converts that shape into this one.
 */
class SaveAttachmentsData extends Data
{
    /**
     * @param  array<int, AttachmentToSaveData>  $attachments
     */
    public function __construct(
        public array $attachments,
        public string $disk = 'attachments',
    ) {}

    /**
     * Convenience factory for the legacy `list<string> $names` + keyed
     * `array<string,string|null> $paths` shape (e.g. Filament form state).
     *
     * @param  list<string>  $names
     * @param  array<string, string|null>  $paths
     */
    public static function fromNamesAndPaths(array $names, array $paths, string $disk = 'attachments'): self
    {
        $attachments = [];
        foreach ($names as $name) {
            $attachments[] = new AttachmentToSaveData(
                name: $name,
                path: $paths[$name] ?? null,
            );
        }

        return new self(attachments: $attachments, disk: $disk);
    }
}
