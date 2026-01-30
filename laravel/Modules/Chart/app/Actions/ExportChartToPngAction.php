<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use RuntimeException;
use Illuminate\Support\Facades\Storage;

use function Safe\base64_decode;
use function Safe\json_encode;
use function Safe\preg_replace;
use function Safe\unpack;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert as WebmozartAssert;

/**
 * Action per esportare grafici Chart.js in formato PNG
 *
 * Questo action gestisce l'export PNG da grafici Chart.js nei widget Filament
 * e salva i file PNG nel filesystem per uso successivo in PDF o altri documenti.
 */
class ExportChartToPngAction
{
    use QueueableAction;

    /**
     * Esporta un grafico Chart.js in formato PNG
     *
     * @param string      $base64Data Base64 dell'immagine (da canvas.toDataURL())
     * @param string|null $filename   Nome file (opzionale)
     * @param string      $disk       Disco storage Laravel
     * @param int         $quality    Qualità PNG (0-100)
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int}
     */
    public function execute(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
        int $quality = 95,
    ): array {
        // Decodifica base64 e rimuovi prefisso "data:image/png;base64,"
        $cleanedData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $cleanedData = is_string($cleanedData) ? $cleanedData : (is_array($cleanedData) ? $cleanedData[0] : '');
        WebmozartAssert::string($cleanedData, 'Failed to clean base64 data');
        $imageData = base64_decode($cleanedData);

        // Genera nome file se non fornito
        $filename = $filename ?? 'chart-'.uniqid().'.png';

        // Salva file PNG
        $result = Storage::disk($disk)->put($filename, $imageData);
        if (false === $result) {
            throw new RuntimeException('Failed to save PNG file');
        }

        return [
            'path' => $filename,
            'url' => Storage::disk($disk)->url($filename),
            'size' => Storage::disk($disk)->size($filename),
            'filename' => $filename,
            'quality' => $quality,
            'format' => 'png',
        ];
    }

    /**
     * Esporta PNG con qualità specifica
     *
     * @param string      $base64Data Base64 dell'immagine
     * @param int         $quality    Qualità (0-100)
     * @param string|null $filename   Nome file
     * @param string      $disk       Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int}
     */
    public function executeWithQuality(
        string $base64Data,
        int $quality,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        return $this->execute($base64Data, $filename, $disk, $quality);
    }

    /**
     * Esporta PNG per uso in PDF (alta qualità)
     *
     * @param string      $base64Data Base64 dell'immagine
     * @param string|null $filename   Nome file
     * @param string      $disk       Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int}
     */
    public function executeForPdf(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        return $this->execute($base64Data, $filename, $disk, 100); // Massima qualità per PDF
    }

    /**
     * Esporta PNG per uso web (qualità bilanciata)
     *
     * @param string      $base64Data Base64 dell'immagine
     * @param string|null $filename   Nome file
     * @param string      $disk       Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int}
     */
    public function executeForWeb(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        return $this->execute($base64Data, $filename, $disk, 85); // Qualità bilanciata per web
    }

    /**
     * Esporta batch di grafici in PNG
     *
     * @param list<string> $charts  Array di base64 data
     * @param string       $prefix  Prefisso per i nomi file
     * @param string       $disk    Disco storage
     * @param int          $quality Qualità PNG
     *
     * @return array Array di risultati
     */
    public function executeBatch(
        array $charts,
        string $prefix = 'chart',
        string $disk = 'public',
        int $quality = 95,
    ): array {
        $results = [];

        foreach ($charts as $index => $base64Data) {
            WebmozartAssert::string($base64Data);
            $filename = $prefix.'-'.($index + 1).'.png';
            $result = $this->execute($base64Data, $filename, $disk, $quality);
            $results[] = $result;
        }

        return $results;
    }

    /**
     * Esporta PNG con metadati aggiuntivi
     *
     * @param string      $base64Data Base64 dell'immagine
     * @param array       $metadata   Metadati aggiuntivi
     * @param string|null $filename   Nome file
     * @param string      $disk       Disco storage
     * @param int         $quality    Qualità PNG
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int, metadata: array}
     */
    public function executeWithMetadata(
        string $base64Data,
        array $metadata = [],
        ?string $filename = null,
        string $disk = 'public',
        int $quality = 95,
    ): array {
        $result = $this->execute($base64Data, $filename, $disk, $quality);

        // Salva metadati in file separato
        if (! empty($metadata)) {
            $metadataFilename = pathinfo($result['filename'], PATHINFO_FILENAME).'.json';
            Storage::disk($disk)->put($metadataFilename, json_encode($metadata, JSON_PRETTY_PRINT));
        }

        return array_merge($result, [
            'metadata' => $metadata,
        ]);
    }

    /**
     * Verifica se un file PNG è valido
     *
     * @param string $filename Nome file
     * @param string $disk     Disco storage
     *
     * @return bool True se il file è un PNG valido
     */
    public function validatePngFile(string $filename, string $disk = 'public'): bool
    {
        if (! Storage::disk($disk)->exists($filename)) {
            return false;
        }

        $content = Storage::disk($disk)->get($filename);
        WebmozartAssert::string($content);
        $content = (string) $content;

        // Verifica signature PNG (primi 8 byte)
        $pngSignature = "\x89PNG\r\n\x1a\n";

        return substr($content, 0, 8) === $pngSignature;
    }

    /**
     * Ottiene informazioni su un file PNG
     *
     * @param string $filename Nome file
     * @param string $disk     Disco storage
     *
     * @return array{width: int, height: int, size: int, valid: bool}|null
     */
    public function getPngInfo(string $filename, string $disk = 'public'): ?array
    {
        if (! $this->validatePngFile($filename, $disk)) {
            return null;
        }

        $content = Storage::disk($disk)->get($filename);
        WebmozartAssert::string($content);
        $content = (string) $content;

        // Estrai dimensioni dal chunk IHDR
        $ihdrPosition = strpos($content, 'IHDR');
        if (false === $ihdrPosition) {
            return null;
        }

        $width = unpack('N', substr($content, $ihdrPosition + 4, 4))[1];
        $height = unpack('N', substr($content, $ihdrPosition + 8, 4))[1];

        WebmozartAssert::integer($width);
        WebmozartAssert::integer($height);

        return [
            'width' => $width,
            'height' => $height,
            'size' => Storage::disk($disk)->size($filename),
            'valid' => true,
        ];
    }
}
