<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 * Azione per convertire un video utilizzando il modello MediaConvert.
 */

namespace Modules\Media\Actions\Video;

use Exception;
use Modules\Media\Datas\ConvertData;
use Modules\Media\Models\MediaConvert;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per convertire video utilizzando MediaConvert e tenere traccia del progresso.
 *
 * @see docs/contracts/convert-video-by-media-convert-action.md
 *
 * @contract docs/contracts/convert-video-by-media-convert-action.md
 */
class ConvertVideoByMediaConvertAction
{
    use QueueableAction;

    /**
     * Converte il video nel formato di `ConvertData`, aggiorna il progresso sul record e ne
     * registra la fine (`percentage` = 100).
     *
     * @see Modules/Media/docs/contracts/convert-video-by-media-convert-action.md
     */
    public function execute(ConvertData $data, MediaConvert $record): string
    {
        if (! $data->exists()) {
            throw new Exception('Il file non esiste');
        }

        $format = $data->getFFMpegFormat();
        $file_new = $record->converted_file;

        if (! $file_new) {
            throw new Exception('Il nome del file convertito non è stato specificato');
        }

        // Il formato (codec, bitrate, preset) e' gia' quello del DTO: va applicato con inFormat().
        // `save()` accetta solo il percorso; `new $format` ricreava il formato senza i parametri scelti.
        FFMpeg::fromDisk($data->disk)
            ->open($data->file)
            ->export()
            ->onProgress(function (float $percentage, float $remaining, float $rate) use ($record): void {
                $record->update([
                    'percentage' => $percentage,
                    'remaining' => $remaining,
                    'rate' => $rate,
                ]);
            })
            ->inFormat($format)
            ->save($file_new);

        // `onProgress` non scatta mai a 100 e `media_converts` non ha una colonna `status`
        // (il vecchio `update(['status' => 'completed'])` non scriveva nulla): la fine si registra in `percentage`.
        $record->update(['percentage' => 100]);

        return $file_new;
    }
}
