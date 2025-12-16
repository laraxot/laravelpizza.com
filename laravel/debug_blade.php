<?php

use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$directories = [
    base_path('Themes/Meetup/resources/views'),
    base_path('Modules/Cms/resources/views'),
];

$directives = ['if', 'foreach', 'for', 'while', 'push', 'section', 'component', 'auth', 'guest', 'can', 'cannot', 'switch', 'error'];

foreach ($directories as $directory) {
    if (!File::exists($directory)) continue;
    
    $files = File::allFiles($directory);
    
    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') continue; // Blade files are .blade.php
        
        $content = File::get($file->getPathname());
        $lines = explode("\n", $content);
        
        $counts = [];
        foreach ($directives as $directive) {
            $counts[$directive] = 0;
        }
        
        foreach ($lines as $line) {
            foreach ($directives as $directive) {
                // Simple regex to count directives
                // Note: This is a basic check and might be fooled by comments or strings
                if (preg_match_all('/@' . $directive . '\b/', $line, $matches)) {
                    $counts[$directive] += count($matches[0]);
                }
                if (preg_match_all('/@end' . $directive . '\b/', $line, $matches)) {
                    $counts[$directive] -= count($matches[0]);
                }
            }
        }
        
        foreach ($counts as $directive => $count) {
            if ($count !== 0) {
                echo "File: " . $file->getRelativePathname() . " - Unbalanced @" . $directive . ": " . $count . "\n";
            }
        }
    }
}

echo "Scan complete.\n";
