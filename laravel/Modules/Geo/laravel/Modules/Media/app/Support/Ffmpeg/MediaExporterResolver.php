<?php

declare(strict_types=1);

namespace Modules\Media\Support\Ffmpeg;

use ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter;
use RuntimeException;

/**
 * Normalizza il risultato della fluent API FFmpeg (MediaExporter + __call verso PHPFFMpeg)
 * per l'analisi statica e runtime sicuro.
 */
final class MediaExporterResolver
{
    /**
     * @param  mixed  $value  Valore restituito da export(), toDisk(), addFilter(), ecc.
     */
    public static function from(mixed $value): MediaExporter
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
