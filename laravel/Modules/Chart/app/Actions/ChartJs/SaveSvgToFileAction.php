<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\ChartJs;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

/**
 * Save Chart.js as SVG file
 * 
 * This action saves the SVG string to a file in the storage directory
 */
class SaveSvgToFileAction
{
    use QueueableAction;

    /**
     * Save SVG content to file
     * 
     * @param string $svgContent The SVG content to save
     * @param string $filename The filename to save (without path)
     * @param string $directory The directory to save the file in (relative to storage)
     * @return string The full path to the saved file
     */
    public function execute(string $svgContent, string $filename = '', string $directory = 'charts'): string
    {
        // Generate filename if not provided
        if (empty($filename)) {
            $filename = 'chart_' . time() . '.svg';
        }
        
        // Ensure directory exists
        $fullPath = storage_path('app/' . $directory);
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        // Ensure filename has .svg extension
        if (!str_ends_with(strtolower($filename), '.svg')) {
            $filename .= '.svg';
        }
        
        $filePath = $fullPath . '/' . $filename;
        
        // Save SVG content to file
        File::put($filePath, $svgContent);
        
        return $filePath;
    }
}