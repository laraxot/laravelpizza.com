<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Ffmpeg;

use ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;

final class ResolveMediaExporterAction
{
    use QueueableAction;

    /**
     * `mixed $value` voluto: normalizza qualunque risultato della catena fluent FFmpeg.
     */
    public function execute(mixed $value): MediaExporter
    {
        if (! $value instanceof MediaExporter) {
            $type = is_object($value) ? $value::class : get_debug_type($value);

            throw new RuntimeException(
                'La catena FFmpeg deve restituire un MediaExporter; ricevuto: '.$type.'.'
            );
        }

        return $value;
    }
}
