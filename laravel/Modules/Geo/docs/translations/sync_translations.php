<?php

require_once __DIR__ . '/../../laravel/vendor/autoload.php';

use Illuminate\Support\Facades\File;

// Bootstrap Laravel
$app = require_once __DIR__ . '/../../laravel/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Starting translation sync from Italian to English and German...\n";

$modulesPath = base_path('Modules');
$sourceLang = 'it';
$targetLangs = ['en', 'de'];

// Get all modules with lang directory
$modules = [];
$directories = File::directories($modulesPath);

foreach ($directories as $directory) {
    $moduleName = basename($directory);
    if (File::exists("{$directory}/lang")) {
        $modules[] = $moduleName;
    }
}

echo "Found " . count($modules) . " modules with lang directory: " . implode(', ', $modules) . "\n\n";

$totalFiles = 0;
$totalTranslations = 0;

foreach ($modules as $module) {
    echo "Processing module: {$module}\n";
    
    $moduleLangPath = "{$modulesPath}/{$module}/lang";
    $sourcePath = "{$moduleLangPath}/{$sourceLang}";
    
    if (!File::exists($sourcePath)) {
        echo "  Source language {$sourceLang} not found, skipping...\n";
        continue;
    }
    
    $sourceFiles = File::glob("{$sourcePath}/*.php");
    
    foreach ($sourceFiles as $sourceFile) {
        $fileName = basename($sourceFile);
        echo "  Processing file: {$fileName}\n";
        
        // Load source translations
        $sourceTranslations = [];
        try {
            $sourceTranslations = require $sourceFile;
            if (!is_array($sourceTranslations)) {
                echo "    Invalid translations file, skipping...\n";
                continue;
            }
        } catch (Exception $e) {
            echo "    Error loading file: " . $e->getMessage() . "\n";
            continue;
        }
        
        if (empty($sourceTranslations)) {
            echo "    No translations found, skipping...\n";
            continue;
        }
        
        $totalFiles++;
        $fileTranslations = 0;
        
        // Sync to target languages
        foreach ($targetLangs as $targetLang) {
            $targetPath = "{$moduleLangPath}/{$targetLang}";
            $targetFile = "{$targetPath}/{$fileName}";
            
            // Create target directory if it doesn't exist
            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0755, true);
                echo "    Created directory: {$targetPath}\n";
            }
            
            // Load existing target translations
            $targetTranslations = [];
            if (File::exists($targetFile)) {
                try {
                    $targetTranslations = require $targetFile;
                    if (!is_array($targetTranslations)) {
                        echo "    Warning: Target file contains non-array data, using empty array\n";
                        $targetTranslations = [];
                    }
                } catch (Exception $e) {
                    echo "    Warning: Error loading target file: " . $e->getMessage() . ", using empty array\n";
                    $targetTranslations = [];
                }
            }
            
            // Merge translations (source takes precedence for missing keys)
            try {
                $mergedTranslations = mergeTranslations($sourceTranslations, $targetTranslations);
            } catch (Exception $e) {
                echo "    Error merging translations: " . $e->getMessage() . ", skipping...\n";
                continue;
            }
            
            // Save merged translations
            saveTranslations($targetFile, $mergedTranslations);
            
            $newKeys = count($mergedTranslations) - count($targetTranslations);
            if ($newKeys > 0) {
                echo "    Added {$newKeys} new translations to {$targetLang}\n";
                $fileTranslations += $newKeys;
            }
        }
        
        $totalTranslations += $fileTranslations;
    }
    
    echo "\n";
}

echo "Sync completed!\n";
echo "Total files processed: {$totalFiles}\n";
echo "Total new translations added: {$totalTranslations}\n";

function mergeTranslations(array $source, array $target): array
{
    $merged = $target;
    
    foreach ($source as $key => $value) {
        if (is_array($value)) {
            $targetValue = $target[$key] ?? [];
            if (!is_array($targetValue)) {
                $targetValue = [];
            }
            $merged[$key] = mergeTranslations($value, $targetValue);
        } else {
            if (!isset($merged[$key])) {
                $merged[$key] = $value;
            }
        }
    }
    
    return $merged;
}

function saveTranslations(string $filePath, array $translations): void
{
    $content = "<?php\n\nreturn [\n";
    $content .= arrayToPhp($translations, 1);
    $content .= "];\n";
    
    File::put($filePath, $content);
}

function arrayToPhp(array $array, int $indent = 0): string
{
    $content = '';
    $indentStr = str_repeat('    ', $indent);
    
    foreach ($array as $key => $value) {
        $content .= $indentStr . "'" . addslashes($key) . "' => ";
        
        if (is_array($value)) {
            $content .= "[\n";
            $content .= arrayToPhp($value, $indent + 1);
            $content .= $indentStr . "],\n";
        } else {
            $content .= "'" . addslashes((string) $value) . "',\n";
        }
    }
    
    return $content;
} 