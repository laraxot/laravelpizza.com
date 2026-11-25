<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;
use function Safe\preg_match_all;

uses(TestCase::class);

/*
 * Nessuna credenziale in chiaro nei docs (DCP-275). Gia' successo: la password di root della macchina di sviluppo copiata in
 * un riepilogo di sistema (10 righe in 10 file, 7 copie solo in Notify) e la password del database in docs/lamp (5 righe).
 * I docs sono tracciati in git e git e' solo in avanti: un segreto committato resta nella storia, quindi va fermato prima.
 *
 * Due forme, misurate su 33.944 file senza falsi positivi dopo la pulizia:
 *  - «<root|sudo|ssh|admin|master|system> password» seguito da un valore tra apici o backtick;
 *  - l'etichetta in grassetto «**Password**» seguita da `:` o `|` e da un valore tra apici o backtick.
 * Segnaposto ammessi: password, secret, changeme, *****, xxx, [omessa], <...>, $VAR, {VAR}, ... Il messaggio riporta file e riga, mai il valore.
 */

it('keeps credentials out of the markdown docs', function (): void {
    $roots = [];
    foreach ([base_path('../docs'), base_path('../bashscripts/docs'), base_path('Modules/*/docs'), base_path('Themes/*/docs')] as $pattern) {
        foreach (glob($pattern) as $dir) {
            if (is_string($dir) && is_dir($dir)) {
                $roots[] = $dir;
            }
        }
    }

    $forms = [
        '/\b(?:root|sudo|ssh|admin|master|system)\s+password\b[^\n]{0,40}?[`\'"]([^`\'"\s]{3,})[`\'"]/i',
        '/\*\*password\*\*\s*[:|]\s*[`\'"]([^`\'"\s]{3,})[`\'"]/i',
    ];
    $placeholder = '/^(?:password|secret|changeme|change[-_]me|your[-_ ]?password|\*+|x+|\[omess[ao]\]|<.*>|\$.*|\{.*\}|\.\.\.|redacted|example|test|testing|none|null)$/i';

    $found = [];
    $finder = Finder::create()->files()->name(['*.md', '*.md.old'])->exclude(['node_modules', 'vendor'])->in($roots);
    foreach ($finder as $file) {
        $text = file_get_contents($file->getRealPath());
        foreach ($forms as $form) {
            if (preg_match_all($form, $text, $matches, PREG_OFFSET_CAPTURE) === 0) {
                continue;
            }
            foreach ($matches[1] as [$value, $offset]) {
                if (preg_match($placeholder, $value) === 1) {
                    continue;
                }
                $line = substr_count(substr($text, 0, (int) $offset), "\n") + 1;
                $found[] = substr($file->getRealPath(), strlen(dirname(base_path())) + 1).':'.$line;
            }
        }
    }

    expect(array_values(array_unique($found)))->toBe([]);
});
