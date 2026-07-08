#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Funzione per il logging
function log_info($message) {
    echo "\033[32m[INFO]\033[0m $message\n";
}

function log_warn($message) {
    echo "\033[33m[WARN]\033[0m $message\n";
}

function log_error($message) {
    echo "\033[31m[ERROR]\033[0m $message\n";
}

// Verifica se il file esiste
if (!isset($argv[1]) || !file_exists($argv[1])) {
    log_error("File non trovato: " . ($argv[1] ?? 'non specificato'));
    exit(1);
}

$file = $argv[1];

// 1. Backup del file originale
copy($file, $file . '.bak');
log_info("Backup creato: {$file}.bak");

// 2. Verifica la sintassi del file
log_info("Verifica sintassi PHP...");
$output = [];
$return_var = 0;
exec("php -l $file 2>&1", $output, $return_var);

if ($return_var !== 0) {
    log_error("Errori di sintassi PHP trovati:");
    echo implode("\n", $output) . "\n";
    exit(1);
}

log_info("Sintassi PHP valida");

// 3. Verifica la formattazione
log_info("Verifica formattazione PHP...");
$output = [];
$return_var = 0;
exec("php-cs-fixer fix --dry-run --diff $file 2>&1", $output, $return_var);

if ($return_var !== 0) {
    log_warn("Problemi di formattazione PHP trovati:");
    echo implode("\n", $output) . "\n";
}

// 4. Verifica lo schema del form
log_info("Verifica schema del form...");
$content = file_get_contents($file);
$schema = json_decode($content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    log_error("Errore nel parsing JSON: " . json_last_error_msg());
    exit(1);
}

// Verifica campi obbligatori
$required_fields = ['name', 'type', 'label'];
foreach ($schema['fields'] as $field) {
    foreach ($required_fields as $required) {
        if (!isset($field[$required])) {
            log_error("Campo mancante '$required' nel form");
            exit(1);
        }
    }
}

log_info("Schema del form valido");

// 5. Verifica i test
if (file_exists('phpunit.xml')) {
    log_info("Esecuzione test...");
    $output = [];
    $return_var = 0;
    exec("php artisan test --filter=" . basename($file) . " 2>&1", $output, $return_var);

    if ($return_var !== 0) {
        log_warn("Test falliti:");
        echo implode("\n", $output) . "\n";
    } else {
        log_info("Test passati");
    }
}

log_info("Verifica completata per: $file");

// 6. Trova altri file con problemi simili
log_info("Ricerca altri file con problemi simili...");
$files_to_check = glob(dirname($file) . '/*.php');

foreach ($files_to_check as $check_file) {
    if ($check_file === $file) continue;
    
    $check_content = file_get_contents($check_file);
    if (strpos($check_content, 'form') !== false) {
        log_warn("File potenzialmente problematico trovato: $check_file");
    }
}
