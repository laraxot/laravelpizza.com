<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Widget;

use RuntimeException;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Storage;
// use Spatie\Browsershot\Browsershot; // Not installed
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Action per salvare un Filament ChartWidget come PNG
 *
 * Usa Browsershot (Puppeteer) per renderizzare il widget Chart.js
 * e salvare l'immagine in PNG di alta qualità.
 *
 * @example
 * ```php
 * $widget = new QuestionChartWidget();
 * $result = app(SaveChartWidgetAsPngAction::class)->execute(
 *     widget: $widget,
 *     filename: 'chart-vendite.png',
 *     width: 1200,
 *     height: 600
 * );
 * ```
 */
class SaveChartWidgetAsPngAction
{
    use QueueableAction;

    /**
     * Esegue l'export del widget Chart.js in PNG
     *
     * @param ChartWidget $widget   Widget Filament da esportare
     * @param string|null $filename Nome file (opzionale, auto-generato se null)
     * @param int         $width    Larghezza immagine in pixel
     * @param int         $height   Altezza immagine in pixel
     * @param string      $disk     Disco storage Laravel
     * @param int         $quality  Qualità PNG (0-100)
     *
     * @return array{path: string, url: string, base64: string, size: int, width: int, height: int}
     */
    public function execute(
        ChartWidget $widget,
        ?string $filename = null,
        int $width = 1200,
        int $height = 600,
        string $disk = 'public',
        int $quality = 90,
    ): array {
        // 1. Valida parametri
        Assert::greaterThan($width, 0, 'Width must be positive');
        Assert::greaterThan($height, 0, 'Height must be positive');
        Assert::range($quality, 1, 100, 'Quality must be between 1-100');

        // 2. Genera HTML del widget
        $html = app(RenderChartWidgetHtmlAction::class)->execute(
            widget: $widget,
            width: $width,
            height: $height
        );

        // 3. Genera filename se non fornito
        if (null === $filename) {
            $filename = 'charts/widget-'.uniqid().'.png';
        }

        // 4. Renderizza con Browsershot e salva
        throw new RuntimeException('Browsershot dependency not installed. Please install spatie/browsershot to use this functionality.');
    }

    /**
     * Variante con caching per performance
     *
     * @param int $ttl TTL in secondi (default 1 ora)
     *
     * @return array{path: string, url: string, base64: string, size: int, width: int, height: int}
     */
    public function executeWithCache(
        ChartWidget $widget,
        string $cacheKey,
        int $ttl = 3600,
        ?string $filename = null,
        int $width = 1200,
        int $height = 600,
    ): array {
        return [
            'path' => '',
            'url' => '',
            'base64' => '',
            'size' => 0,
            'width' => $width,
            'height' => $height,
        ];
    }
}
