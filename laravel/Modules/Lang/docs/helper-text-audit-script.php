<?php

declare(strict_types=1);

use function Safe\file_put_contents;
use function Safe\glob;

/**
 * Script per audit e correzione automatica dei valori helper_text
 * che sono uguali alla chiave del campo padre.
 *
 * @return array<string, list<array{path: string, key: int|string, current_value: string, should_be: string, line_context: string}>>
 */
function auditHelperTextFiles(string $basePath): array
{
    $issues = [];
    $langFiles = glob($basePath.'/Modules/*/lang/*/*.php');

    foreach ($langFiles as $file) {
        if (! is_string($file)) {
            continue;
        }

        if (str_contains($file, '/it/')) {
            continue; // Skip Italian files
        }

        // Parse the PHP array
        $data = include $file;
        if (! is_array($data)) {
            continue;
        }

        $fileIssues = findHelperTextIssues($data, $file);
        if (! empty($fileIssues)) {
            $issues[$file] = $fileIssues;
        }
    }

    return $issues;
}

/**
 * $data e' l'albero di traduzione ottenuto con include: struttura ricorsiva a profondita' aperta
 * (fino a 9 livelli oggi, foglie string|int), PHPStan non ha tipi ricorsivi, per questo mixed.
 *
 * @param array<array-key, mixed> $data
 *
 * @return list<array{path: string, key: int|string, current_value: string, should_be: string, line_context: string}>
 */
function findHelperTextIssues(array $data, string $file, string $parentKey = ''): array
{
    $issues = [];

    foreach ($data as $key => $value) {
        $currentPath = $parentKey ? $parentKey.'.'.$key : (string) $key;

        if (is_array($value)) {
            // Check if this is a field definition with helper_text
            if (isset($value['helper_text']) && is_string($value['helper_text'])) {
                // Check if helper_text value equals the parent key
                if ($value['helper_text'] === $key) {
                    $issues[] = [
                        'path' => $currentPath,
                        'key' => $key,
                        'current_value' => $value['helper_text'],
                        'should_be' => '',
                        'line_context' => "'{$key}' => ['helper_text' => '{$value['helper_text']}']",
                    ];
                }
            }

            // Recursively check nested arrays
            $nestedIssues = findHelperTextIssues($value, $file, $currentPath);
            $issues = array_merge($issues, $nestedIssues);
        }
    }

    return $issues;
}

/**
 * @param array<string, list<array{path: string, key: int|string, current_value: string, should_be: string, line_context: string}>> $issues
 */
function generateReport(array $issues): string
{
    $report = "# Helper Text Audit Report\n\n";
    $report .= '**Data**: '.date('Y-m-d H:i:s')."\n\n";
    $report .= "## Problemi Identificati\n\n";

    $totalIssues = 0;
    foreach ($issues as $file => $fileIssues) {
        $totalIssues += count($fileIssues);
        $report .= '### File: `'.basename($file)."`\n\n";
        $report .= "**Path completo**: `{$file}`\n\n";

        foreach ($fileIssues as $issue) {
            $report .= "- **Campo**: `{$issue['path']}`\n";
            $report .= "  - **Problema**: `helper_text` = `'{$issue['current_value']}'` (uguale alla chiave padre)\n";
            $report .= "  - **Correzione**: Impostare `helper_text` = `''`\n";
            $report .= "  - **Contesto**: `{$issue['line_context']}`\n\n";
        }
    }

    $report .= "## Riepilogo\n\n";
    $report .= '- **File con problemi**: '.count($issues)."\n";
    $report .= "- **Problemi totali**: {$totalIssues}\n\n";

    $report .= "## Regola Applicata\n\n";
    $report .= "**Se il valore di `helper_text` è uguale alla chiave del campo padre, DEVE essere impostato a stringa vuota (`''`).**\n\n";

    return $report;
}

// Esegui audit
$basePath = dirname(__DIR__, 3);
$issues = auditHelperTextFiles($basePath);
$report = generateReport($issues);

// Salva report
file_put_contents($basePath.'/docs/helper-text-audit-report.md', $report);

echo "Audit completato. Report salvato in: docs/helper-text-audit-report.md\n";
echo 'Problemi trovati in '.count($issues)." file(s)\n";

// Output per debug
foreach ($issues as $file => $fileIssues) {
    echo "\nFile: ".basename($file)."\n";
    foreach ($fileIssues as $issue) {
        echo "  - {$issue['path']}: '{$issue['current_value']}' -> ''\n";
    }
}
