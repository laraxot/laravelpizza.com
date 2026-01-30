<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\ChartJs;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

final class ExportToSvgAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $chartData
     * @param array<string, mixed> $options
     *
     * @return array{
     *     svg_content: string,
     *     export_options: array{width: int, height: int, filename: string, title: string, includeStyles: bool},
     *     timestamp: int
     * }
     */
    public function execute(array $chartData, array $options = []): array
    {
        $exportOptions = $this->resolveExportOptions($chartData, $options);
        $payload = $this->extractChartPayload($chartData);

        return [
            'svg_content' => $this->generateSvgFromData($payload, $exportOptions),
            'export_options' => $exportOptions,
            'timestamp' => \time(),
        ];
    }

    /**
     * @param array<string, mixed> $chartData
     * @param array<string, mixed> $options
     *
     * @return array{width: int, height: int, filename: string, title: string, includeStyles: bool}
     */
    private function resolveExportOptions(array $chartData, array $options): array
    {
        /** @var float|int|string|null $widthInput */
        $widthInput = $options['width'] ?? $chartData['width'] ?? 800;
        $width = $this->sanitizeDimension($widthInput);

        /** @var float|int|string|null $heightInput */
        $heightInput = $options['height'] ?? $chartData['height'] ?? 600;
        $height = $this->sanitizeDimension($heightInput);

        $filename = (string) ($options['filename'] ?? ('chart_'.\time().'.svg'));
        $title = (string) ($options['title'] ?? $chartData['title'] ?? 'Chart');
        $includeStyles = isset($options['includeStyles']) ? (bool) $options['includeStyles'] : true;

        return [
            'width' => $width,
            'height' => $height,
            'filename' => '' !== $filename ? $filename : 'chart.svg',
            'title' => $title,
            'includeStyles' => $includeStyles,
        ];
    }

    /**
     * @param array<string, mixed> $chartData
     *
     * @return array{
     *     type: string,
     *     datasets: list<array{
     *         label: string|null,
     *         data: list<float>,
     *         backgroundColor: list<string>,
     *         borderColor: list<string>
     *     }>,
     *     labels: list<string>
     * }
     */
    private function extractChartPayload(array $chartData): array
    {
        $type = \is_string($chartData['type'] ?? null) ? (string) $chartData['type'] : 'bar';
        $data = $chartData['data'] ?? [];
        if (! \is_array($data)) {
            $data = [];
        }

        $rawDatasets = $data['datasets'] ?? [];
        $rawLabels = $data['labels'] ?? [];

        $datasets = [];
        if (\is_array($rawDatasets)) {
            foreach ($rawDatasets as $dataset) {
                if (! \is_array($dataset)) {
                    continue;
                }

                $data = $this->normalizeNumericSeries($dataset['data'] ?? []);
                if ([] === $data) {
                    continue;
                }

                $datasets[] = [
                    'label' => isset($dataset['label']) ? (string) $dataset['label'] : null,
                    'data' => $data,
                    'backgroundColor' => $this->normalizeColorPalette($dataset['backgroundColor'] ?? null, \count($data)),
                    'borderColor' => $this->normalizeColorPalette($dataset['borderColor'] ?? null, \count($data)),
                ];
            }
        }

        $labels = $this->normalizeLabels(\is_array($rawLabels) ? $rawLabels : [], $datasets);

        return [
            'type' => $type,
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    /**
     * @return list<float>
     */
    private function normalizeNumericSeries(mixed $rawValues): array
    {
        if (! \is_array($rawValues)) {
            return [];
        }

        $series = [];
        foreach ($rawValues as $value) {
            if (is_numeric($value)) {
                $series[] = (float) $value;
            }
        }

        return $series;
    }

    /**
     * @return list<string>
     */
    private function normalizeColorPalette(mixed $rawColors, int $length): array
    {
        if (\is_string($rawColors)) {
            $rawColors = [$rawColors];
        }

        if (! \is_array($rawColors)) {
            $rawColors = [];
        }

        $palette = [];
        foreach ($rawColors as $color) {
            if (\is_string($color) && '' !== \trim($color)) {
                $palette[] = $color;
            }
        }

        if ([] === $palette) {
            return \array_fill(0, \max($length, 1), '#36A2EB');
        }

        if (\count($palette) < $length) {
            $palette = \array_merge(
                $palette,
                \array_fill(\count($palette), $length - \count($palette), $palette[0])
            );
        }

        return \array_slice($palette, 0, $length);
    }

    /**
     * @param array<int|string, mixed>       $rawLabels
     * @param list<array{data: list<float>}> $datasets
     *
     * @return list<string>
     */
    private function normalizeLabels(array $rawLabels, array $datasets): array
    {
        $labels = [];
        foreach ($rawLabels as $label) {
            if (\is_string($label)) {
                $labels[] = $label;
            } elseif (is_numeric($label)) {
                $labels[] = (string) $label;
            }
        }

        $maxDataPoints = $this->maxDataPoints($datasets);
        if ([] === $labels && $maxDataPoints > 0) {
            for ($index = 0; $index < $maxDataPoints; ++$index) {
                $labels[] = \sprintf('Label %d', $index + 1);
            }
        }

        if (\count($labels) < $maxDataPoints) {
            for ($index = \count($labels); $index < $maxDataPoints; ++$index) {
                $labels[] = \sprintf('Label %d', $index + 1);
            }
        }

        return $labels;
    }

    /**
     * @param list<array{data: list<float>}> $datasets
     */
    private function maxDataPoints(array $datasets): int
    {
        $max = 0;
        foreach ($datasets as $dataset) {
            $max = \max($max, \count($dataset['data']));
        }

        return $max;
    }

    /**
     * @param array{
     *     type: string,
     *     datasets: list<array{
     *         label: string|null,
     *         data: list<float>,
     *         backgroundColor: list<string>,
     *         borderColor: list<string>
     *     }>,
     *     labels: list<string>
     * } $chartPayload
     * @param array{width: int, height: int, title: string, includeStyles: bool, filename: string} $options
     */
    private function generateSvgFromData(array $chartPayload, array $options): string
    {
        $width = $options['width'];
        $height = $options['height'];

        $svgParts = [];
        $svgParts[] = \sprintf('<svg width="%d" height="%d" xmlns="http://www.w3.org/2000/svg">', $width, $height);

        if ('' !== $options['title']) {
            $svgParts[] = \sprintf('<title>%s</title>', $this->escape($options['title']));
        }

        if ($options['includeStyles']) {
            $svgParts[] = '<style>';
            $svgParts[] = '.chart-title{font:bold 16px sans-serif;fill:#333;}';
            $svgParts[] = '.chart-axis{stroke:#333;stroke-width:1;}';
            $svgParts[] = '.chart-grid{stroke:#ccc;stroke-dasharray:2,2;}';
            $svgParts[] = '</style>';
        }

        $svgParts[] = match ($chartPayload['type']) {
            'bar' => $this->generateBarChartSvg($chartPayload['datasets'], $chartPayload['labels'], $width, $height),
            'line' => $this->generateLineChartSvg($chartPayload['datasets'], $chartPayload['labels'], $width, $height),
            'doughnut', 'pie' => $this->generatePieChartSvg($chartPayload['datasets'], $chartPayload['labels'], $width, $height),
            default => $this->generateGenericChartSvg($width, $height),
        };

        $svgParts[] = '</svg>';

        return implode('', $svgParts);
    }

    /**
     * @param list<array{
     *     label: string|null,
     *     data: list<float>,
     *     backgroundColor: list<string>,
     *     borderColor: list<string>
     * }> $datasets
     * @param list<string> $labels
     */
    private function generateBarChartSvg(array $datasets, array $labels, int $width, int $height): string
    {
        if ([] === $datasets || [] === $labels) {
            return '';
        }

        $svg = '';
        $margin = ['top' => 40, 'right' => 20, 'bottom' => 60, 'left' => 60];
        $chartWidth = \max($width - $margin['left'] - $margin['right'], 1);
        $chartHeight = \max($height - $margin['top'] - $margin['bottom'], 1);

        $maxValue = $this->determineMaxValue($datasets);
        $barCount = \count($labels);
        $barWidth = $chartWidth / \max($barCount * 2, 1);
        $xOffset = $margin['left'];
        $yOffset = $margin['top'] + $chartHeight;
        $datasetCount = \max(\count($datasets), 1);

        foreach ($datasets as $datasetIndex => $dataset) {
            $barSpacing = $barWidth / $datasetCount;
            $datasetOffset = $datasetIndex * $barSpacing;
            $colorPalette = $dataset['backgroundColor'];

            foreach ($dataset['data'] as $i => $value) {
                $barHeight = ($value / $maxValue) * $chartHeight;
                $x = $xOffset + ($i * 2 * $barWidth) + $datasetOffset;
                $y = $yOffset - $barHeight;
                $color = $this->escape($colorPalette[$i] ?? $colorPalette[0] ?? '#36A2EB');

                $svg .= \sprintf(
                    '<rect x="%f" y="%f" width="%f" height="%f" fill="%s" stroke="#000" stroke-width="0.5"/>',
                    $x,
                    $y,
                    $barWidth,
                    $barHeight,
                    $color
                );
            }
        }

        $svg .= '<g font-size="12" fill="#333">';
        for ($i = 0; $i < $barCount; ++$i) {
            $x = $xOffset + ($i * 2 * $barWidth) + ($barWidth * $datasetCount / 2);
            $y = $yOffset + 15;

            $svg .= \sprintf(
                '<text x="%f" y="%f" text-anchor="middle">%s</text>',
                $x,
                $y,
                $this->escape($labels[$i])
            );
        }
        $svg .= '</g>';

        $svg .= '<g font-size="12" fill="#333">';
        for ($i = 0; $i <= 5; ++$i) {
            $yValue = ($maxValue / 5) * $i;
            $y = $yOffset - ($yValue / $maxValue) * $chartHeight;

            $svg .= \sprintf(
                '<text x="%f" y="%f" text-anchor="end">%s</text>',
                (float) ($margin['left'] - 10),
                $y + 4,
                \number_format($yValue, 0)
            );
        }
        $svg .= '</g>';

        $svg .= \sprintf(
            '<line x1="%d" y1="%d" x2="%d" y2="%d" stroke="#000" stroke-width="1"/>',
            $margin['left'],
            $yOffset,
            $width - $margin['right'],
            $yOffset
        );

        $svg .= \sprintf(
            '<line x1="%d" y1="%d" x2="%d" y2="%d" stroke="#000" stroke-width="1"/>',
            $margin['left'],
            $margin['top'],
            $margin['left'],
            $yOffset
        );

        return $svg;
    }

    /**
     * @param list<array{
     *     label: string|null,
     *     data: list<float>,
     *     backgroundColor: list<string>,
     *     borderColor: list<string>
     * }> $datasets
     * @param list<string> $labels
     */
    private function generateLineChartSvg(array $datasets, array $labels, int $width, int $height): string
    {
        if ([] === $datasets || [] === $labels) {
            return '';
        }

        $svg = '';
        $margin = ['top' => 40, 'right' => 20, 'bottom' => 60, 'left' => 60];
        $chartWidth = \max($width - $margin['left'] - $margin['right'], 1);
        $chartHeight = \max($height - $margin['top'] - $margin['bottom'], 1);

        $maxValue = $this->determineMaxValue($datasets);
        $xOffset = $margin['left'];
        $yOffset = $margin['top'] + $chartHeight;
        $xStep = $chartWidth / \max(\count($labels) - 1, 1);

        foreach ($datasets as $dataset) {
            $color = $this->escape($dataset['borderColor'][0] ?? $dataset['backgroundColor'][0] ?? '#36A2EB');
            $points = [];

            foreach ($dataset['data'] as $i => $value) {
                $x = $xOffset + ($i * $xStep);
                $y = $yOffset - (($value / $maxValue) * $chartHeight);
                $points[] = ['x' => $x, 'y' => $y];
            }

            if (\count($points) < 2) {
                continue;
            }

            $path = 'M';
            foreach ($points as $point) {
                $path .= \sprintf(' %f,%f L', $point['x'], $point['y']);
            }
            $path = rtrim($path, ' L');

            $svg .= \sprintf('<path d="%s" fill="none" stroke="%s" stroke-width="2"/>', $path, $color);

            foreach ($points as $point) {
                $svg .= \sprintf(
                    '<circle cx="%f" cy="%f" r="4" fill="%s" stroke="#fff" stroke-width="1"/>',
                    $point['x'],
                    $point['y'],
                    $color
                );
            }
        }

        $svg .= '<g font-size="12" fill="#333">';
        foreach ($labels as $index => $label) {
            $x = $xOffset + ($index * $xStep);
            $y = $yOffset + 15;

            $svg .= \sprintf(
                '<text x="%f" y="%f" text-anchor="middle">%s</text>',
                $x,
                $y,
                $this->escape($label)
            );
        }
        $svg .= '</g>';

        $svg .= '<g font-size="12" fill="#333">';
        for ($i = 0; $i <= 5; ++$i) {
            $yValue = ($maxValue / 5) * $i;
            $y = $yOffset - ($yValue / $maxValue) * $chartHeight;

            $svg .= \sprintf(
                '<text x="%f" y="%f" text-anchor="end">%s</text>',
                (float) ($margin['left'] - 10),
                $y + 4,
                \number_format($yValue, 0)
            );
        }
        $svg .= '</g>';

        $svg .= \sprintf(
            '<line x1="%d" y1="%d" x2="%d" y2="%d" stroke="#000" stroke-width="1"/>',
            $margin['left'],
            $yOffset,
            $width - $margin['right'],
            $yOffset
        );

        $svg .= \sprintf(
            '<line x1="%d" y1="%d" x2="%d" y2="%d" stroke="#000" stroke-width="1"/>',
            $margin['left'],
            $margin['top'],
            $margin['left'],
            $yOffset
        );

        return $svg;
    }

    /**
     * @param list<array{
     *     label: string|null,
     *     data: list<float>,
     *     backgroundColor: list<string>,
     *     borderColor: list<string>
     * }> $datasets
     * @param list<string> $labels
     */
    private function generatePieChartSvg(array $datasets, array $labels, int $width, int $height): string
    {
        if ([] === $datasets || [] === $labels) {
            return '';
        }

        $dataset = $datasets[0];
        if ([] === $dataset['data']) {
            return '';
        }

        $svg = '';
        $centerX = $width / 2;
        $centerY = $height / 2;
        $radius = (float) (\min($width, $height) * 0.4);

        $total = \array_sum($dataset['data']);
        if ($total <= 0.0) {
            return '';
        }

        $startAngle = 0.0;
        foreach ($dataset['data'] as $index => $value) {
            $angle = ($value / $total) * 360;
            $endAngle = $startAngle + $angle;
            $largeArc = $angle > 180 ? 1 : 0;

            $startX = $centerX + $radius * \cos(\deg2rad($startAngle));
            $startY = $centerY + $radius * \sin(\deg2rad($startAngle));
            $endX = $centerX + $radius * \cos(\deg2rad($endAngle));
            $endY = $centerY + $radius * \sin(\deg2rad($endAngle));
            $color = $this->escape($dataset['backgroundColor'][$index] ?? $dataset['borderColor'][$index] ?? '#36A2EB');

            $path = \sprintf(
                'M %f %f L %f %f A %f %f 0 %d 1 %f %f Z',
                $centerX,
                $centerY,
                $startX,
                $startY,
                $radius,
                $radius,
                $largeArc,
                $endX,
                $endY
            );

            $svg .= \sprintf('<path d="%s" fill="%s" stroke="#fff" stroke-width="1"/>', $path, $color);

            $labelAngle = $startAngle + $angle / 2;
            $labelRadius = $radius * 0.7;
            $labelX = $centerX + $labelRadius * \cos(\deg2rad($labelAngle));
            $labelY = $centerY + $labelRadius * \sin(\deg2rad($labelAngle));

            $labelValue = $labels[$index] ?? '';
            $svg .= \sprintf(
                '<text x="%f" y="%f" text-anchor="middle" dominant-baseline="middle" font-size="12" fill="#fff">%s</text>',
                $labelX,
                $labelY,
                $this->escape($labelValue)
            );

            $startAngle = $endAngle;
        }

        return $svg;
    }

    private function generateGenericChartSvg(int $width, int $height): string
    {
        return \sprintf(
            '<text x="%d" y="%d" text-anchor="middle" dominant-baseline="middle" font-size="16" fill="#666">%s</text>',
            (int) ($width / 2),
            (int) ($height / 2),
            $this->escape('Chart Export')
        );
    }

    /**
     * @param list<array{data: list<float>}> $datasets
     */
    private function determineMaxValue(array $datasets): float
    {
        $maxValue = 0.0;
        foreach ($datasets as $dataset) {
            if ([] !== $dataset['data']) {
                $maxValue = \max($maxValue, \max($dataset['data']));
            }
        }

        return $maxValue > 0 ? $maxValue : 1.0;
    }

    private function sanitizeDimension(int|float|string|null $value): int
    {
        if (\is_string($value)) {
            $value = (int) $value;
        }

        $dimension = (int) $value;

        return \max($dimension, 1);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
    }
}
