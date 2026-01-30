<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use RuntimeException;
use Illuminate\Support\Facades\Storage;

use function Safe\base64_decode;
use function Safe\preg_replace;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Action per esportare grafici Chart.js in formato SVG
 *
 * Questo action gestisce l'export SVG da grafici Chart.js nei widget Filament
 * e salva i file SVG nel filesystem per uso successivo in PDF o altri documenti.
 */
class ExportChartToSvgAction
{
    use QueueableAction;

    /**
     * Esporta un grafico Chart.js in formato SVG
     *
     * @param string      $base64Data Base64 dell'immagine (da canvas.toDataURL())
     * @param string|null $filename   Nome file (opzionale)
     * @param string      $disk       Disco storage Laravel
     *
     * @return array{path: string, url: string, size: int, filename: string}
     */
    public function execute(
        string $base64Data,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        // Decodifica base64 e rimuovi prefisso "data:image/png;base64,"
        $cleanedData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $cleanedData = is_string($cleanedData) ? $cleanedData : (is_array($cleanedData) ? $cleanedData[0] : '');
        Assert::string($cleanedData, 'Failed to clean base64 data');
        $imageData = base64_decode($cleanedData);

        // Genera nome file se non fornito
        $filename = $filename ?? 'chart-'.uniqid().'.svg';

        // Crea SVG wrapper con immagine PNG embedded
        $svgContent = $this->createSvgWithEmbeddedImage($imageData);

        // Salva file SVG
        $result = Storage::disk($disk)->put($filename, $svgContent);
        if (false === $result) {
            throw new RuntimeException('Failed to save SVG file');
        }

        return [
            'path' => $filename,
            'url' => Storage::disk($disk)->url($filename),
            'size' => Storage::disk($disk)->size($filename),
            'filename' => $filename,
            'format' => 'svg',
        ];
    }

    /**
     * Crea contenuto SVG con immagine PNG embedded
     *
     * @param string $imageData Dati immagine PNG
     * @param int    $width     Larghezza SVG (opzionale)
     * @param int    $height    Altezza SVG (opzionale)
     *
     * @return string Contenuto SVG
     */
    private function createSvgWithEmbeddedImage(
        string $imageData,
        int $width = 800,
        int $height = 600,
    ): string {
        // Converti PNG in base64 per embedding in SVG
        $base64Image = base64_encode($imageData);

        return <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     width="{$width}"
     height="{$height}"
     viewBox="0 0 {$width} {$height}">
    <title>Chart Export</title>
    <desc>Chart.js export in SVG format</desc>
    <image xlink:href="data:image/png;base64,{$base64Image}"
           width="{$width}"
           height="{$height}" />
</svg>
SVG;
    }

    /**
     * Esporta SVG con dimensione personalizzata
     *
     * @param string      $base64Data Base64 dell'immagine
     * @param int         $width      Larghezza SVG
     * @param int         $height     Altezza SVG
     * @param string|null $filename   Nome file
     * @param string      $disk       Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string, width: int, height: int}
     */
    public function executeWithCustomSize(
        string $base64Data,
        int $width,
        int $height,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        $result = $this->execute($base64Data, $filename, $disk);

        // Sovrascrivi SVG con dimensioni personalizzate
        $cleanedData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $cleanedData = is_string($cleanedData) ? $cleanedData : (is_array($cleanedData) ? $cleanedData[0] : '');
        Assert::string($cleanedData, 'Failed to clean base64 data');
        $imageData = base64_decode($cleanedData);
        $svgContent = $this->createSvgWithEmbeddedImage($imageData, $width, $height);

        Storage::disk($disk)->put($result['filename'], $svgContent);

        return array_merge($result, [
            'width' => $width,
            'height' => $height,
            'size' => Storage::disk($disk)->size($result['filename']),
        ]);
    }

    /**
     * Esporta SVG con metadati aggiuntivi
     *
     * @param string      $base64Data Base64 dell'immagine
     * @param array       $metadata   Metadati aggiuntivi
     * @param string|null $filename   Nome file
     * @param string      $disk       Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string, metadata: array}
     */
    public function executeWithMetadata(
        string $base64Data,
        array $metadata = [],
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        $result = $this->execute($base64Data, $filename, $disk);

        // Aggiungi metadati al SVG
        $cleanedData = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
        $cleanedData = is_string($cleanedData) ? $cleanedData : (is_array($cleanedData) ? $cleanedData[0] : '');
        Assert::string($cleanedData, 'Failed to clean base64 data');
        $imageData = base64_decode($cleanedData);
        $svgContent = $this->createSvgWithMetadata($imageData, $metadata);

        Storage::disk($disk)->put($result['filename'], $svgContent);

        return array_merge($result, [
            'metadata' => $metadata,
            'size' => Storage::disk($disk)->size($result['filename']),
        ]);
    }

    /**
     * Crea SVG con metadati aggiuntivi
     */
    private function createSvgWithMetadata(string $imageData, array $metadata): string
    {
        $base64Image = base64_encode($imageData);
        $width = $metadata['width'] ?? 800;
        $height = $metadata['height'] ?? 600;
        $title = $metadata['title'] ?? 'Chart Export';
        $description = $metadata['description'] ?? 'Chart.js export in SVG format';

        Assert::integer($width);
        Assert::integer($height);
        Assert::string($title);
        Assert::string($description);

        $metadataXml = '';
        foreach ($metadata as $key => $value) {
            if (! \in_array($key, ['width', 'height', 'title', 'description'], true)) {
                Assert::string($key);
                Assert::string($value);
                $metadataXml .= "    <meta name=\"{$key}\" content=\"{$value}\" />\n";
            }
        }

        return <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     width="{$width}"
     height="{$height}"
     viewBox="0 0 {$width} {$height}">
    <title>{$title}</title>
    <desc>{$description}</desc>
{$metadataXml}
    <image xlink:href="data:image/png;base64,{$base64Image}"
           width="{$width}"
           height="{$height}" />
</svg>
SVG;
    }
}
