<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\ChartJs;

use Spatie\QueueableAction\QueueableAction;

/**
 * Export Chart.js to PNG image
 * 
 * This action handles the server-side preparation for Chart.js to PNG conversion.
 * Since Chart.js runs client-side, this action provides the data structure
 * needed for client-side canvas to PNG conversion.
 */
class ExportToPngAction
{
    use QueueableAction;

    /**
     * Prepare chart data for PNG export
     * 
     * @param array $chartData The chart configuration data
     * @param string $chartId The HTML ID of the chart canvas
     * @param array $options Export options including quality, dimensions, etc.
     * @return array Prepared data for client-side PNG export
     */
    public function execute(array $chartData, string $chartId, array $options = []): array
    {
        $defaultOptions = [
            'quality' => 1.0,  // PNG quality (0.0 to 1.0)
            'scale' => 2,      // Scale factor for high DPI
            'filename' => 'chart_' . time() . '.png',
            'width' => $chartData['width'] ?? 800,
            'height' => $chartData['height'] ?? 600,
        ];

        $exportOptions = array_merge($defaultOptions, $options);

        return [
            'chart_id' => $chartId,
            'chart_data' => $chartData,
            'export_options' => $exportOptions,
            'timestamp' => time(),
        ];
    }
}