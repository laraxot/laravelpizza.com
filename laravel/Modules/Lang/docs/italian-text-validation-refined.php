<?php

declare(strict_types=1);

/**
 * Script raffinato per identificare VERI testi italiani in file di traduzione non italiani
 * Esclude falsi positivi come "email", "password" che sono termini internazionali.
 */
function auditRealItalianText(string $basePath): array
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

    // Pattern italiani REALI (escludendo termini internazionali)
    $realItalianPatterns = [
        // Frasi chiaramente italiane
        'è obbligatorio',
        'campo obbligatorio',
        'inserisci il',
        'inserisci la',
        'seleziona il',
        'seleziona la',
        'questo campo',
        'il campo',
        'la password',
        'l\'email',
        'il nome',
        'il cognome',
        'l\'indirizzo',
        'il telefono',

        // Verbi italiani coniugati
        'inserisci',
        'seleziona',
        'conferma',
        'elimina',
        'modifica',
        'visualizza',
        'aggiungi',
        'rimuovi',
        'cerca',
        'filtra',
        'ordina',

        // Sostantivi chiaramente italiani
        'informazioni',
        'dettagli',
        'descrizione',
        'cognome',
        'indirizzo',
        'telefono',
        'messaggio',
        'notifica',
        'attenzione',
        'avviso',
        'errore',
        'successo',

        // Articoli italiani (con spazi per evitare falsi positivi)
        ' il ',
        ' la ',
        ' lo ',
        ' gli ',
        ' le ',
        ' un ',
        ' una ',
        ' uno ',
        ' del ',
        ' della ',
        ' dello ',
        ' degli ',
        ' delle ',
        ' al ',
        ' alla ',
        ' allo ',
        ' agli ',
        ' alle ',
        ' dal ',
        ' dalla ',
        ' dallo ',
        ' dagli ',
        ' dalle ',
        ' nel ',
        ' nella ',
        ' nello ',
        ' negli ',
        ' nelle ',
        ' sul ',
        ' sulla ',
        ' sullo ',
        ' sugli ',
        ' sulle ',

        // Caratteri accentati italiani
        'à',
        'è',
        'é',
        'ì',
        'ò',
        'ù',

        // Preposizioni italiane (con spazi)
        ' di ',
        ' da ',
        ' in ',
        ' con ',
        ' su ',
        ' per ',
        ' tra ',
        ' fra ',

        // Congiunzioni italiane
        ' e ',
        ' o ',
        ' ma ',
        ' però ',
        ' quindi ',
        ' allora ',

        // Avverbi italiani
        ' non ',
        ' più ',
        ' molto ',
        ' poco ',
        ' tanto ',
        ' sempre ',
        ' mai ',
        ' già ',
        ' ancora ',

        // Parole tipicamente italiane
        'dati',
        'campi',
        'nuovo',
        'nuova',
        'tutti',
        'tutte',
        'tutto',
        'nessuno',
        'nessuna',
        'primo',
        'ultimo',
        'precedente',
        'successivo',
        'pagina',
        'salva',
        'annulla',
        'chiudi',
        'apri',
        'mostra',
        'nascondi',
    ];

    // Termini da ESCLUDERE (falsi positivi)
    $excludePatterns = [
        'email',
        'password',
        'admin',
        'user',
        'login',
        'logout',
        'register',
        'create',
        'update',
        'delete',
        'edit',
        'view',
        'save',
        'cancel',
        'submit',
        'reset',
        'search',
        'filter',
        'sort',
        'page',
        'next',
        'previous',
        'first',
        'last',
        'all',
        'none',
        'success',
        'error',
        'warning',
        'info',
        'message',
        'notification',
        'alert',
        'confirm',
        'close',
        'open',
        'show',
        'hide',
    ];

    foreach ($nonItalianFiles as $file) {
        $content = file_get_contents($file);
        if (! $content) {
            continue;
        }

        $fileIssues = [];
        $lines = explode("\n", $content);

        foreach ($realItalianPatterns as $pattern) {
            $lineNumber = 0;
            foreach ($lines as $line) {
                ++$lineNumber;
                if (stripos($line, $pattern) !== false) {
                    // Verifica che non sia un falso positivo
                    $isExcluded = false;
                    foreach ($excludePatterns as $exclude) {
                        if (stripos($line, $exclude) !== false && stripos($line, $pattern) !== false) {
                            // Controlla se il pattern è parte del termine escluso
                            if (str_contains(strtolower($exclude), strtolower(trim($pattern)))) {
                                $isExcluded = true;
                                break;
                            }
                        }
                    }

                    if (! $isExcluded) {
                        $fileIssues[] = [
                            'pattern' => $pattern,
                            'line' => $lineNumber,
                            'content' => trim($line),
                            'language' => getLanguageFromPath($file),
                        ];
                    }
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

function generateRefinedReport(array $issues): string
{
    $report = "# Refined Italian Text Audit Report\n\n";
    $report .= '**Data**: '.date('Y-m-d H:i:s')."\n";
    $report .= "**Scope**: Identificazione di VERI testi italiani in file non italiani (escludendo falsi positivi)\n\n";

    $totalIssues = 0;
    $totalFiles = count($issues);

    if ($totalFiles > 0) {
        $report .= "## ❌ Problemi Reali Identificati\n\n";

        foreach ($issues as $file => $fileIssues) {
            $totalIssues += count($fileIssues);
            $language = getLanguageFromPath($file);
            $report .= '### File: `'.basename($file)."` ({$language})\n\n";
            $report .= "**Path completo**: `{$file}`\n\n";

            foreach ($fileIssues as $issue) {
                $report .= "- **Linea {$issue['line']}**: Testo italiano `{$issue['pattern']}` trovato\n";
                $report .= "  ```php\n  {$issue['content']}\n  ```\n";
                $report .= "  **Azione richiesta**: Tradurre in {$language}\n\n";
            }
        }
    } else {
        $report .= "## ✅ Risultato Audit\n\n";
        $report .= "**Nessun testo italiano reale trovato nei file di traduzione non italiani!**\n\n";
        $report .= "Tutti i file di traduzione sono conformi e non contengono testi italiani residui.\n\n";
    }

    $report .= "## Riepilogo\n\n";
    $report .= "- **File con problemi reali**: {$totalFiles}\n";
    $report .= "- **Problemi reali totali**: {$totalIssues}\n\n";

    $report .= "## Metodologia\n\n";
    $report .= "Questo audit esclude falsi positivi come:\n";
    $report .= "- Termini internazionali: `email`, `password`, `admin`, `login`, ecc.\n";
    $report .= "- Termini tecnici comuni in più lingue\n";
    $report .= "- Nomi di proprietà o chiavi tecniche\n\n";

    $report .= "Si concentra su:\n";
    $report .= "- Frasi chiaramente italiane\n";
    $report .= "- Articoli e preposizioni italiane\n";
    $report .= "- Verbi coniugati in italiano\n";
    $report .= "- Caratteri accentati italiani\n";
    $report .= "- Sostantivi tipicamente italiani\n\n";

    $report .= "## Regola Applicata\n\n";
    $report .= "**I file di traduzione non italiani NON devono contenere testi chiaramente italiani.**\n\n";
    $report .= "Ogni testo deve essere tradotto nella lingua appropriata del file, escludendo termini internazionali standard.\n\n";

    return $report;
}

// Esegui audit raffinato
$basePath = '/var/www/html/_bases/base_saluteora/laravel';
echo "Inizio audit raffinato per testi italiani REALI in file non italiani...\n";

$issues = auditRealItalianText($basePath);
$report = generateRefinedReport($issues);

// Salva report
file_put_contents($basePath.'/docs/italian-text-refined-audit-report.md', $report);

echo "Audit raffinato completato. Report salvato in: docs/italian-text-refined-audit-report.md\n";
echo 'File con problemi reali: '.count($issues)."\n";

// Output dettagliato
if (! empty($issues)) {
    echo "\nProblemi REALI trovati:\n";
    foreach ($issues as $file => $fileIssues) {
        echo "\n".basename($file).' ('.getLanguageFromPath($file)."):\n";
        foreach ($fileIssues as $issue) {
            echo "  Linea {$issue['line']}: '{$issue['pattern']}' in: {$issue['content']}\n";
        }
    }
} else {
    echo "\n✅ Nessun testo italiano REALE trovato in file non italiani!\n";
    echo "Tutti i file di traduzione sono conformi.\n";
}
