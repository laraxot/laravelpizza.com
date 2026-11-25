<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 * Azione per convertire un video utilizzando ConvertData.
 */

namespace Modules\Media\Actions\Video;

use Exception;
use Modules\Media\Datas\ConvertData;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per convertire video utilizzando i dati di conversione specificati.
 *
 * @see docs/contracts/convert-video-by-convert-data-action.md
 *
 * @contract docs/contracts/convert-video-by-convert-data-action.md
 */
class ConvertVideoByConvertDataAction
{
    use QueueableAction;

    /**
     * Converte il video nel formato descritto da `ConvertData` e restituisce il percorso prodotto.
     *
     * @see Modules/Media/docs/contracts/convert-video-by-convert-data-action.md
     */
    public function execute(ConvertData $data): string
    {
        if (! $data->exists()) {
            throw new Exception('Il file non esiste');
        }

        $format = $data->getFFMpegFormat();
        $file_new = $data->getConvertedFilename();

        if (! $file_new) {
            throw new Exception('Il nome del file convertito non è stato specificato');
        }

        // Il formato (codec, bitrate, preset) e' gia' quello del DTO: va applicato con inFormat().
        // `save()` accetta solo il percorso; `new $format` ricreava il formato senza i parametri scelti.
        FFMpeg::fromDisk($data->disk)
            ->open($data->file)
            ->export()
            ->inFormat($format)
            ->save($file_new);

        // Restituisci il percorso del file senza usare il metodo url()
        return $file_new;
    }
}
