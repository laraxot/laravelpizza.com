<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\ChartJs;

use InvalidArgumentException;
use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

use function Safe\base64_decode;

/**
 * Save Chart.js as PNG file
 * 
 * This action handles server-side PNG saving for Chart.js
 * Since Chart.js is client-side, this action can be used to 
 * save base64 encoded PNG data received from client
 */
class SavePngToFileAction
{
    use QueueableAction;

    /**
     * Save base64 PNG data to file
     * 
     * @param string $base64Data The base64 encoded PNG data (with or without data URI)
     * @param string $filename The filename to save (without path)
     * @param string $directory The directory to save the file in (relative to storage)
     * @return string The full path to the saved file
     */
    public function execute(string $base64Data, string $filename = '', string $directory = 'charts'): string
    {
        // Extract base64 data if it includes data URI
        if (str_starts_with($base64Data, 'data:image/png;base64,')) {
            $base64Data = substr($base64Data, strlen('data:image/png;base64,'));
        } elseif (str_starts_with($base64Data, 'data:image/')) {
            // Handle other image formats by extracting base64 part
            $commaPos = strpos($base64Data, ',');
            if ($commaPos !== false) {
                $base64Data = substr($base64Data, $commaPos + 1);
            }
        }
        
        // Validate base64
        if (!base64_decode($base64Data, true)) {
            throw new InvalidArgumentException('Invalid base64 data provided');
        }
        
        // Generate filename if not provided
        if (empty($filename)) {
            $filename = 'chart_' . time() . '.png';
        }
        
        // Ensure directory exists
        $fullPath = storage_path('app/' . $directory);
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        // Ensure filename has .png extension
        if (!str_ends_with(strtolower($filename), '.png')) {
            $filename .= '.png';
        }
        
        $filePath = $fullPath . '/' . $filename;
        
        // Decode and save PNG data to file
        $imageData = base64_decode($base64Data);
        File::put($filePath, $imageData);
        
        return $filePath;
    }
}