<?php
// Simple test to see if Laravel can bootstrap without accessing config
try {
    require_once __DIR__.'/vendor/autoload.php';
    
    // Try to create Laravel application instance without accessing config
    $app = require_once __DIR__.'/bootstrap/app.php';
    
    echo "Laravel application created successfully\n";
    echo "App class: " . get_class($app) . "\n";
    echo "Base Path: " . $app->basePath() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}