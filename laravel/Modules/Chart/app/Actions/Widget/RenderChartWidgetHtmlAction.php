<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Widget;

use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Filament\Widgets\ChartWidget;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

/**
 * Action per renderizzare un Filament ChartWidget come HTML standalone
 *
 * Genera HTML completo con Chart.js embedded, pronto per essere
 * renderizzato da Browsershot o visualizzato in browser.
 *
 * @example
 * ```php
 * $widget = new QuestionChartWidget();
 * $html = app(RenderChartWidgetHtmlAction::class)->execute($widget);
 * ```
 */
class RenderChartWidgetHtmlAction
{
    use QueueableAction;

    /**
     * Versione Chart.js da usare (CDN)
     */
    private const CHARTJS_VERSION = '4.4.3';

    /**
     * Versione chartjs-plugin-datalabels
     */
    private const DATALABELS_VERSION = '2.2.0';

    /**
     * Renderizza il widget come HTML standalone
     *
     * @param ChartWidget $widget Widget Filament da renderizzare
     * @param int $width Larghezza canvas
     * @param int $height Altezza canvas
     * @return string HTML completo
     */
    public function execute(
        ChartWidget $widget,
        int $width = 1200,
        int $height = 600
    ): string {
        Assert::greaterThan($width, 0, 'Width must be positive');
        Assert::greaterThan($height, 0, 'Height must be positive');

        // 1. Estrai dati dal widget
        $data = $this->getWidgetData($widget);
        $type = $this->getWidgetType($widget);
        $options = $this->getWidgetOptions($widget);
        $heading = $this->getWidgetHeading($widget);

        // 2. Prepara configurazione Chart.js
        $chartConfig = [
            'type' => $type,
            'data' => $data,
            'options' => $options,
        ];

        $chartConfigJson = json_encode($chartConfig, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // 3. Genera HTML
        return $this->createHtml(
            chartConfig: $chartConfigJson,
            width: $width,
            height: $height,
            heading: $heading
        );
    }

    /**
     * Crea HTML completo per Chart.js
     *
     * @param string $chartConfig Configurazione Chart.js in JSON
     * @param int $width Larghezza
     * @param int $height Altezza
     * @param string|null $heading Titolo
     * @return string HTML
     */
    private function createHtml(
        string $chartConfig,
        int $width,
        int $height,
        ?string $heading = null
    ): string {
        $title = $heading ?? 'Chart Widget';
        $chartJsVersion = self::CHARTJS_VERSION;
        $datalabelsVersion = self::DATALABELS_VERSION;

        return <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@{$chartJsVersion}/dist/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@{$datalabelsVersion}"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: white;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding: 20px;
        }

        .chart-container {
            width: {$width}px;
            height: {$height}px;
            position: relative;
        }

        .chart-heading {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="chart-heading">{$title}</div>
    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>

    <script>
        // Aspetta che il DOM sia pronto
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chart').getContext('2d');

            // Configurazione Chart.js dal widget Filament
            const config = {$chartConfig};

            // Crea il grafico
            const chart = new Chart(ctx, config);

            console.log('✅ Chart.js renderizzato con successo');
        });
    </script>
</body>
</html>
HTML;
    }

    /**
     * Ottieni dati dal widget
     *
     * @param ChartWidget $widget
     * @return array<string, mixed>
     */
    private function getWidgetData(ChartWidget $widget): array
    {
        try {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod('getData');
            $method->setAccessible(true);

            /** @var array<string, mixed> $data */
            $data = $method->invoke($widget);

            return $data;
        } catch (ReflectionException $e) {
            throw new RuntimeException("Failed to get widget data: {$e->getMessage()}", previous: $e);
        }
    }

    /**
     * Ottieni tipo grafico dal widget
     *
     * @param ChartWidget $widget
     * @return string
     */
    private function getWidgetType(ChartWidget $widget): string
    {
        try {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod('getType');
            $method->setAccessible(true);

            /** @var string $type */
            $type = $method->invoke($widget);

            return $type;
        } catch (ReflectionException $e) {
            return 'line'; // Default fallback
        }
    }

    /**
     * Ottieni opzioni dal widget
     *
     * @param ChartWidget $widget
     * @return array<string, mixed>
     */
    private function getWidgetOptions(ChartWidget $widget): array
    {
        try {
            $reflection = new ReflectionClass($widget);
            $method = $reflection->getMethod('getOptions');
            $method->setAccessible(true);

            /** @var array<string, mixed> $options */
            $options = $method->invoke($widget);

            return $options;
        } catch (ReflectionException $e) {
            return []; // Default empty options
        }
    }

    /**
     * Ottieni heading dal widget
     *
     * @param ChartWidget $widget
     * @return string|null
     */
    private function getWidgetHeading(ChartWidget $widget): ?string
    {
        try {
            $reflection = new ReflectionClass($widget);
            $property = $reflection->getProperty('heading');
            $property->setAccessible(true);

            /** @var string|null $heading */
            $heading = $property->getValue($widget);

            return $heading;
        } catch (ReflectionException $e) {
            return null;
        }
    }
}
