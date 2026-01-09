<?php

declare(strict_types=1);

/**
 * Script specifico per identificare la parola "obbligatorio" e varianti
 * in file di traduzione non italiani.
 */
function auditObbligatorioInNonItalianFiles(string $basePath): array
{
    $issues = [];
    $nonItalianFiles = [];

    // Trova tutti i file di traduzione non italiani
    $patterns = [
        $basePath.'/*/lang/en/*.php',
        $basePath.'/*/lang/de/*.php',
        $basePath.'/*/lang/es/*.php',
        $basePath.'/*/lang/fr/*.php',
    ];

    foreach ($patterns as $pattern) {
        $files = glob($pattern);
        $nonItalianFiles = array_merge($nonItalianFiles, $files);
    }

    // Pattern specifici per "obbligatorio" e varianti
    $obbligatorioPatterns = [
        'obbligatorio',
        'obbligatoria',
        'obbligatori',
        'obbligatorie',
        'è obbligatorio',
        'è obbligatoria',
        'sono obbligatori',
        'sono obbligatorie',
        'campo obbligatorio',
        'campi obbligatori',
        'dato obbligatorio',
        'dati obbligatori',
        'informazione obbligatoria',
        'informazioni obbligatorie',
        'valore obbligatorio',
        'valori obbligatori',
        'Obbligatorio',
        'Obbligatoria',
        'Obbligatori',
        'Obbligatorie',
        'OBBLIGATORIO',
        'OBBLIGATORIA',
        'OBBLIGATORI',
        'OBBLIGATORIE',
    ];

    foreach ($nonItalianFiles as $file) {
        $content = file_get_contents($file);
        if (! $content) {
            continue;
        }

        $fileIssues = [];
        $lines = explode("\n", $content);

        foreach ($obbligatorioPatterns as $pattern) {
            $lineNumber = 0;
            foreach ($lines as $line) {
                ++$lineNumber;
                if (stripos($line, $pattern) !== false) {
                    $fileIssues[] = [
                        'pattern' => $pattern,
                        'line' => $lineNumber,
                        'content' => trim($line),
                        'language' => getLanguageFromPath($file),
                        'suggested_translation' => getSuggestedTranslation($pattern, getLanguageFromPath($file)),
                    ];
                }
            }
        }

        if (! empty($fileIssues)) {
            $issues[$file] = $fileIssues;
        }
    }

    return $issues;
}

function getLanguageFromPath(string $file): string
{
    if (str_contains($file, '/lang/en/')) {
        return 'English';
    }
    if (str_contains($file, '/lang/de/')) {
        return 'German';
    }
    if (str_contains($file, '/lang/es/')) {
        return 'Spanish';
    }
    if (str_contains($file, '/lang/fr/')) {
        return 'French';
    }

    return 'Unknown';
}

function getSuggestedTranslation(string $italianText, string $targetLanguage): string
{
    $translations = [
        'obbligatorio' => [
            'English' => 'required',
            'German' => 'erforderlich',
            'Spanish' => 'obligatorio',
            'French' => 'obligatoire',
        ],
        'obbligatoria' => [
            'English' => 'required',
            'German' => 'erforderlich',
            'Spanish' => 'obligatoria',
            'French' => 'obligatoire',
        ],
        'obbligatori' => [
            'English' => 'required',
            'German' => 'erforderlich',
            'Spanish' => 'obligatorios',
            'French' => 'obligatoires',
        ],
        'obbligatorie' => [
            'English' => 'required',
            'German' => 'erforderlich',
            'Spanish' => 'obligatorias',
            'French' => 'obligatoires',
        ],
        'è obbligatorio' => [
            'English' => 'is required',
            'German' => 'ist erforderlich',
            'Spanish' => 'es obligatorio',
            'French' => 'est obligatoire',
        ],
        'campo obbligatorio' => [
            'English' => 'required field',
            'German' => 'Pflichtfeld',
            'Spanish' => 'campo obligatorio',
            'French' => 'champ obligatoire',
        ],
    ];

    $lowerPattern = strtolower($italianText);
    if (isset($translations[$lowerPattern][$targetLanguage])) {
        return $translations[$lowerPattern][$targetLanguage];
    }

    // Fallback generico
    switch ($targetLanguage) {
        case 'English':
            return 'required';
        case 'German':
            return 'erforderlich';
        case 'Spanish':
            return 'obligatorio';
        case 'French':
            return 'obligatoire';
        default:
            return 'required';
    }
}

function generateObbligatorioReport(array $issues): string
{
    $report = "# Audit \"Obbligatorio\" in Non-Italian Translation Files\n\n";
    $report .= '**Data**: '.date('Y-m-d H:i:s')."\n";
    $report .= "**Scope**: Identificazione della parola \"obbligatorio\" e varianti in file di traduzione non italiani\n\n";

    $totalIssues = 0;
    $totalFiles = count($issues);

    if ($totalFiles > 0) {
        $report .= "## ❌ Problemi Identificati\n\n";

        foreach ($issues as $file => $fileIssues) {
            $totalIssues += count($fileIssues);
            $language = getLanguageFromPath($file);
            $report .= '### File: `'.basename($file)."` ({$language})\n\n";
            $report .= "**Path completo**: `{$file}`\n\n";

            foreach ($fileIssues as $issue) {
                $report .= "- **Linea {$issue['line']}**: Testo italiano `{$issue['pattern']}` trovato\n";
                $report .= "  ```php\n  {$issue['content']}\n  ```\n";
                $report .= "  **Traduzione suggerita**: `{$issue['suggested_translation']}`\n\n";
            }
        }

        $report .= "## Correzioni Richieste\n\n";
        foreach ($issues as $file => $fileIssues) {
            $language = getLanguageFromPath($file);
            $report .= '### '.basename($file)." ({$language})\n\n";
            foreach ($fileIssues as $issue) {
                $report .= "- Linea {$issue['line']}: `{$issue['pattern']}` → `{$issue['suggested_translation']}`\n";
            }
            $report .= "\n";
        }
    } else {
        $report .= "## ✅ Risultato Audit\n\n";
        $report .= "**Nessuna occorrenza di \"obbligatorio\" trovata nei file di traduzione non italiani!**\n\n";
        $report .= "Tutti i file di traduzione sono conformi e non contengono la parola \"obbligatorio\" in italiano.\n\n";
    }

    $report .= "## Riepilogo\n\n";
    $report .= "- **File con problemi**: {$totalFiles}\n";
    $report .= "- **Problemi totali**: {$totalIssues}\n\n";

    $report .= "## Traduzioni Standard\n\n";
    $report .= "| Italiano | English | German | Spanish | French |\n";
    $report .= "|----------|---------|--------|---------|--------|\n";
    $report .= "| obbligatorio | required | erforderlich | obligatorio | obligatoire |\n";
    $report .= "| è obbligatorio | is required | ist erforderlich | es obligatorio | est obligatoire |\n";
    $report .= "| campo obbligatorio | required field | Pflichtfeld | campo obligatorio | champ obligatoire |\n\n";

    $report .= "## Regola Applicata\n\n";
    $report .= "**La parola \"obbligatorio\" e sue varianti NON devono apparire in file di traduzione non italiani.**\n\n";
    $report .= "Ogni occorrenza deve essere tradotta nella lingua appropriata del file.\n\n";

    return $report;
}

// Esegui audit specifico per "obbligatorio"
$basePath = '/var/www/html/_bases/base_saluteora/laravel';
echo "Inizio audit specifico per \"obbligatorio\" in file non italiani...\n";

$issues = auditObbligatorioInNonItalianFiles($basePath);
$report = generateObbligatorioReport($issues);

// Salva report
file_put_contents($basePath.'/docs/obbligatorio-audit-report.md', $report);

echo "Audit \"obbligatorio\" completato. Report salvato in: docs/obbligatorio-audit-report.md\n";
echo 'File con problemi: '.count($issues)."\n";

// Output dettagliato
if (! empty($issues)) {
    echo "\nProblemi \"obbligatorio\" trovati:\n";
    foreach ($issues as $file => $fileIssues) {
        echo "\n".basename($file).' ('.getLanguageFromPath($file)."):\n";
        foreach ($fileIssues as $issue) {
            echo "  Linea {$issue['line']}: '{$issue['pattern']}' → '{$issue['suggested_translation']}'\n";
        }
    }
} else {
    echo "\n✅ Nessuna occorrenza di \"obbligatorio\" trovata in file non italiani!\n";
    echo "Tutti i file di traduzione sono conformi.\n";
}
