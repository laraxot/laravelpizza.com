<?php

declare(strict_types=1);

namespace Modules\Chart\Actions;

use Illuminate\Contracts\Support\Htmlable;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per esportare grafici da widget Filament in SVG e PNG
 *
 * Questo action gestisce l'export di grafici direttamente dai widget Filament
 * senza bisogno di controller o rotte API, utilizzando solo le funzionalità
 * native di Filament e Livewire.
 */
class ExportChartFromWidgetAction
{
    use QueueableAction;

    /**
     * Esporta un grafico da widget Filament in SVG e PNG
     *
     * @param ChartWidget $widget       Widget Filament con grafico
     * @param string      $chartId      ID del canvas del grafico
     * @param string|null $filenameBase Nome base per i file (opzionale)
     * @param string      $disk         Disco storage Laravel
     *
     * @return array{svg: array, png: array, widget_class: string}
     */
    public function execute(
        ChartWidget $widget,
        string $chartId,
        ?string $filenameBase = null,
        string $disk = 'public',
    ): array {
        $widgetClass = \get_class($widget);
        $filenameBase = $filenameBase ?? 'chart-'.class_basename($widgetClass).'-'.uniqid();

        // Simula export (in realtà dovrebbe essere fatto via Livewire/JavaScript)
        $base64Data = $this->simulateChartExport($widget, $chartId);

        // Esporta in SVG
        $svgResult = app(ExportChartToSvgAction::class)->execute(
            base64Data: $base64Data,
            filename: $filenameBase.'.svg',
            disk: $disk
        );

        // Esporta in PNG
        $pngResult = app(ExportChartToPngAction::class)->execute(
            base64Data: $base64Data,
            filename: $filenameBase.'.png',
            disk: $disk,
            quality: 95
        );

        return [
            'svg' => $svgResult,
            'png' => $pngResult,
            'widget_class' => $widgetClass,
            'chart_id' => $chartId,
            'exported_at' => now()->toISOString(),
        ];
    }

    /**
     * Esporta solo SVG da widget Filament
     *
     * @param ChartWidget $widget   Widget Filament con grafico
     * @param string      $chartId  ID del canvas del grafico
     * @param string|null $filename Nome file (opzionale)
     * @param string      $disk     Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string}
     */
    public function executeSvg(
        ChartWidget $widget,
        string $chartId,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        $base64Data = $this->simulateChartExport($widget, $chartId);

        return app(ExportChartToSvgAction::class)->execute(
            base64Data: $base64Data,
            filename: $filename,
            disk: $disk
        );
    }

    /**
     * Esporta solo PNG da widget Filament
     *
     * @param ChartWidget $widget   Widget Filament con grafico
     * @param string      $chartId  ID del canvas del grafico
     * @param string|null $filename Nome file (opzionale)
     * @param string      $disk     Disco storage
     * @param int         $quality  Qualità PNG (0-100)
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int}
     */
    public function executePng(
        ChartWidget $widget,
        string $chartId,
        ?string $filename = null,
        string $disk = 'public',
        int $quality = 95,
    ): array {
        $base64Data = $this->simulateChartExport($widget, $chartId);

        return app(ExportChartToPngAction::class)->execute(
            base64Data: $base64Data,
            filename: $filename,
            disk: $disk,
            quality: $quality
        );
    }

    /**
     * Esporta PNG per PDF (alta qualità)
     *
     * @param ChartWidget $widget   Widget Filament con grafico
     * @param string      $chartId  ID del canvas del grafico
     * @param string|null $filename Nome file (opzionale)
     * @param string      $disk     Disco storage
     *
     * @return array{path: string, url: string, size: int, filename: string, quality: int}
     */
    public function executePngForPdf(
        ChartWidget $widget,
        string $chartId,
        ?string $filename = null,
        string $disk = 'public',
    ): array {
        return $this->executePng($widget, $chartId, $filename, $disk, 100);
    }

    /**
     * Simula export del grafico (placeholder per implementazione reale)
     *
     * In un'implementazione reale, questo dovrebbe essere fatto client-side
     * via JavaScript/Livewire, ma per ora restituiamo un placeholder.
     *
     * @return string Base64 placeholder
     */
    private function simulateChartExport(object $widget, string $chartId): string
    {
        // Placeholder per implementazione reale
        // In produzione, questo dovrebbe essere fatto client-side con:
        // - chart.toBase64Image() per Chart.js
        // - Invio a backend via Livewire

        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
    }

    /**
     * Verifica se un widget può essere esportato
     *
     * @return bool True se il widget può essere esportato
     */
    public function canExportWidget(): bool
    {
        return true;
    }

    /**
     * Ottiene informazioni sul widget per l'export
     *
     * @param ChartWidget $widget Widget da analizzare
     *
     * @return array{class: string, title: string|null, description: string|null, chart_type: string|null}
     */
    public function getWidgetInfo(ChartWidget $widget): array
    {
        $heading = $widget->getHeading();

        $title = null;

        if (null !== $heading) {
            $title = $heading instanceof Htmlable
                ? $heading->toHtml()
                : (string) $heading;
        }

        return [
            'class' => \get_class($widget),
            'title' => $title,
            'description' => null,
            'chart_type' => null,
        ];
    }
}
