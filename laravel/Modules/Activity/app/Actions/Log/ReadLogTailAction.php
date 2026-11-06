<?php

declare(strict_types=1);

namespace Modules\Activity\Actions\Log;

use Modules\Activity\Datas\LogTailData;
use RuntimeException;
use Safe\Exceptions\SafeExceptionInterface;
use Spatie\QueueableAction\QueueableAction;

use function Safe\fclose;
use function Safe\filesize;
use function Safe\fopen;
use function Safe\stream_get_contents;

/**
 * Legge solo la CODA di un file di log (gli ultimi N byte), senza mai caricarlo intero in memoria:
 * `laravel.log` con canale `single` puo' pesare centinaia di MB e il server ha un memory_limit basso.
 *
 * Se il file e' piu' grande della finestra letta, la prima riga (probabilmente tagliata a meta') viene
 * scartata cosi' le voci mostrate sono complete. I byte non UTF-8 vengono ripuliti per non rompere
 * la pagina.
 */
class ReadLogTailAction
{
    use QueueableAction;

    public const int DEFAULT_BYTES = 262144; // 256 KiB

    public const int MIN_BYTES = 1024;

    // ponytail: massimo 4 MiB letti per richiesta (memory_limit basso sul server): ricerca e filtri valgono
    // solo su questa parte; per cercare in tutto il file serve una ricerca a blocchi (grep in streaming).
    public const int MAX_BYTES = 4194304; // 4 MiB

    /**
     * @throws RuntimeException se il file non esiste, non e' leggibile o non si riesce a leggere
     */
    public function execute(string $absolutePath, int $maxBytes = self::DEFAULT_BYTES): LogTailData
    {
        $maxBytes = max(self::MIN_BYTES, min($maxBytes, self::MAX_BYTES));

        // Controllo esplicito prima delle funzioni sul file: un file sparito o non leggibile (per esempio
        // ruotato tra l'elenco e la lettura) darebbe altrimenti un errore PHP poco chiaro.
        if (! is_file($absolutePath) || ! is_readable($absolutePath)) {
            throw new RuntimeException('Il file di log non esiste o non e\' leggibile.');
        }

        try {
            $size = filesize($absolutePath);
            if ($size === 0) {
                return new LogTailData(content: '', size: 0, bytesRead: 0, truncated: false);
            }

            $start = max(0, $size - $maxBytes);
            $chunk = $this->readFrom($absolutePath, $start, $maxBytes);
        } catch (SafeExceptionInterface $e) {
            throw new RuntimeException('Impossibile leggere il file di log.', 0, $e);
        }

        $truncated = $start > 0;
        if ($truncated) {
            $newline = strpos($chunk, "\n");
            if ($newline !== false) {
                $chunk = substr($chunk, $newline + 1);
            }
        }

        return new LogTailData(
            content: mb_scrub($chunk, 'UTF-8'),
            size: $size,
            bytesRead: strlen($chunk),
            truncated: $truncated,
        );
    }

    /**
     * @throws SafeExceptionInterface
     */
    private function readFrom(string $absolutePath, int $start, int $maxBytes): string
    {
        $handle = fopen($absolutePath, 'rb');

        try {
            if ($start > 0 && fseek($handle, $start) !== 0) {
                throw new RuntimeException('Impossibile posizionarsi nel file di log.');
            }

            return stream_get_contents($handle, $maxBytes);
        } finally {
            fclose($handle);
        }
    }
}
