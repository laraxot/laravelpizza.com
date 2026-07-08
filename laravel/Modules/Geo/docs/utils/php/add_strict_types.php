<?php

declare(strict_types=1);

/**
 * Script per aggiungere automaticamente declare(strict_types=1); a tutti i file PHP
 * 
 * Questo script cerca ricorsivamente tutti i file PHP nel progetto e aggiunge
 * la dichiarazione strict_types se non è già presente. Esclude automaticamente
 * le directory vendor, node_modules, storage e bootstrap/cache.
 * 
 * @author Claude AI
 * @version 1.0.0
 * @since 2024-04-22
 */

function addStrictTypesToFile(string $filePath): void {
    $content = file_get_contents($filePath);
    
    // Se il file inizia già con declare(strict_types=1), salta
    if (strpos($content, 'declare(strict_types=1);') !== false) {
        return;
    }
    
    // Aggiungi declare(strict_types=1); dopo <?php
    $newContent = preg_replace('/^<\?php\s*/', "<?php\ndeclare(strict_types=1);\n", $content);
    
    // Scrivi il contenuto modificato
    file_put_contents($filePath, $newContent);
    echo "Aggiunto strict_types a: $filePath\n";
}

function processDirectory(string $directory): void {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            addStrictTypesToFile($file->getPathname());
        }
    }
}

// Directory principale del progetto
$rootDir = __DIR__ . '/../../..';

// Elenco delle directory da escludere
$excludeDirs = [
    'vendor',
    'node_modules',
    'storage',
    'bootstrap/cache'
];

// Processa la directory principale
processDirectory($rootDir);

echo "Completato!\n"; 