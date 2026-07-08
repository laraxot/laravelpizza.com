#!/usr/bin/env php
<?php
declare(strict_types=1);

// Script per generare report PHPStan e documentazione automatica per ogni modulo
$projectRoot = realpath(__DIR__ . '/../');
if (false === $projectRoot) {
    fwrite(STDERR, "Impossibile determinare la directory del progetto.\n");
    exit(1);
}

$phpstanBin = $projectRoot . '/laravel/vendor/bin/phpstan';
if (!file_exists($phpstanBin)) {
    fwrite(STDERR, "PHPStan non trovato in {$phpstanBin}.\n");
    exit(1);
}

$modulesDir = $projectRoot . '/laravel/Modules';
$rootDocsDir = $projectRoot . '/docs';
$rootIndexFile = $rootDocsDir . '/phpstan_modules_index.md';

$rootIndexLines = [
    "# Indice Report PHPStan Moduli",
    ""
];

echo "Inizio generazione report PHPStan per i moduli...\n";
foreach (scandir($modulesDir) as $module) {
    if (in_array($module, ['.', '..'], true)) {
        continue;
    }
    $modulePath = $modulesDir . "/{$module}";
    if (!is_dir($modulePath)) {
        continue;
    }

    $docsDir = $modulePath . '/docs';
    $phpstanDir = $docsDir . '/phpstan';
    if (!is_dir($phpstanDir)) {
        mkdir($phpstanDir, 0775, true);
    }

    echo "- Modulo: {$module}\n";
    $rootIndexLines[] = "## Modulo **{$module}**";
    $rootIndexLines[] = "";

    for ($level = 1; $level <= 10; $level++) {
        $jsonFile = "{$phpstanDir}/level_{$level}.json";
        $mdFile   = "{$phpstanDir}/level_{$level}.md";

        // Esegui PHPStan
        $cmd = escapeshellarg($phpstanBin) . ' analyse ' . escapeshellarg($modulePath . '/app') . ' -l ' . $level . ' --error-format=json';
        exec($cmd, $outputLines, $retVal);
        file_put_contents($jsonFile, implode("\n", $outputLines));
        $outputLines = [];

        // Genera MD con analisi
        $data = json_decode(file_get_contents($jsonFile), true) ?: [];
        $date = date('Y-m-d H:i');
        $mdLines = [
            "# PHPStan Level {$level} - Modulo {$module}",
            "",
            "**Data generazione:** {$date}",
            "",
            "## Errori rilevati e soluzioni proposte",
            ""
        ];

        if (!empty($data['files'])) {
            foreach ($data['files'] as $file => $info) {
                foreach ($info['messages'] as $msg) {
                    $lineNum = $msg['line'] ?? '-';
                    $message = $msg['message'] ?? '';
                    $mdLines[] = "- **{$file}:{$lineNum}** - {$message}";
                    $mdLines[] = "  - **Perché:** spiegazione architetturale e contesto.";
                    $mdLines[] = "  - **Cosa:** proposta di correzione.";
                    $mdLines[] = "";
                }
            }
        } else {
            $mdLines[] = "Nessun errore trovato al livello {$level}.";
        }

        $relativeIndex = str_repeat('../', 4) . 'docs/phpstan_modules_index.md';
        $mdLines[] = "## Collegamenti";
        $mdLines[] = "- Torna all'indice principale: [Indice Report PHPStan Moduli]({$relativeIndex})";

        file_put_contents($mdFile, implode("\n", $mdLines));

        $relMdPath = "laravel/Modules/{$module}/docs/phpstan/level_{$level}.md";
        $rootIndexLines[] = "- [Livello {$level}]({$relMdPath})";
    }
    $rootIndexLines[] = "";
}

file_put_contents($rootIndexFile, implode("\n", $rootIndexLines));

// Inserisco parsing composer.json per ogni modulo e creazione docs/autoload.md
foreach (scandir($modulesDir) as $module) {
    if (in_array($module, ['.', '..'], true)) {
        continue;
    }
    $modulePath = $modulesDir . "/{$module}";
    if (!is_dir($modulePath)) {
        continue;
    }
    $docsDir = $modulePath . '/docs';
    $autoloadFile = $docsDir . '/autoload.md';
    $composerPath = $modulePath . '/composer.json';
    if (is_file($composerPath)) {
        $comp = json_decode(file_get_contents($composerPath), true) ?: [];
        $lines = [
            "# PSR-4 Autoload e Namespace",
            "",
        ];
        if (isset($comp['autoload']['psr-4']) && is_array($comp['autoload']['psr-4'])) {
            foreach ($comp['autoload']['psr-4'] as $ns => $path) {
                $lines[] = "- Namespace **{$ns}** => cartella **{$path}**";
            }
            $lines[] = "";
            $lines[] = "**Spiegazione:** Il namespace di classe non include il segmento 'app', anche se presente nel path. Ad esempio, `app/Filament` mappa in `{$module}\\Filament`.";
        } else {
            $lines[] = "Nessuna configurazione PSR-4 trovata in composer.json.";
        }
        file_put_contents($autoloadFile, implode("\n", $lines));
        // Aggiungo link nell'indice principale
        $relDocs = "laravel/Modules/{$module}/docs/autoload.md";
        file_put_contents($rootIndexFile, file_get_contents($rootIndexFile) . "- [Autoload e Namespace]({$relDocs})\n", FILE_APPEND);
    }
}

// Aggiorna README.md di ogni modulo con link ai report PHPStan
foreach (scandir($modulesDir) as $module) {
    if (in_array($module, ['.', '..'], true)) {
        continue;
    }
    $modulePath = $modulesDir . "/{$module}";
    $docsDir = $modulePath . '/docs';
    $moduleReadme = $docsDir . '/README.md';
    if (file_exists($moduleReadme)) {
        $content = file_get_contents($moduleReadme);
        // Rimuovo eventuale sezione precedente
        $content = preg_replace('/## Report PHPStan[\\s\\S]*?(?=## |$)/', '', $content);
        $section = "\n## Report PHPStan\n";
        for ($lvl = 1; $lvl <= 10; $lvl++) {
            $section .= "- [Livello $lvl](phpstan/level_{$lvl}.md)\n";
        }
        $content .= $section;
        file_put_contents($moduleReadme, $content);
    }
}

// Aggiorna README.md principale in docs con link all'indice PHPStan
$rootReadme = $rootDocsDir . '/README.md';
if (file_exists($rootReadme)) {
    $rootContent = file_get_contents($rootReadme);
    $rootContent = preg_replace('/## Report PHPStan Moduli[\\s\\S]*?(?=## |$)/', '', $rootContent);
    $rootContent .= "\n## Report PHPStan Moduli\n- [Indice Report PHPStan Moduli](phpstan_modules_index.md)\n";
    file_put_contents($rootReadme, $rootContent);
}

echo "Generazione completata. Indice principale: {$rootIndexFile}\n";
