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
 */
class ConvertVideoByConvertDataAction
{
    use QueueableAction;

    /**
     * Execute the action.
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

        // Instanziamo il formato prima di usarlo
        $formatInstance = new $format;

        FFMpeg::fromDisk($data->disk)
            ->open($data->file)
            ->export()
            ->addFilter('-preset', 'ultrafast')
            // Utilizziamo il formato istanziato come parametro
            // @phpstan-ignore-next-line method.notFound
            ->save($file_new, $formatInstance);

        // Restituisci il percorso del file senza usare il metodo url()
        return $file_new;
    }
}
