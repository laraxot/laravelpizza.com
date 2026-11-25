<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match_all;

uses(TestCase::class);

/**
 * In Filament 5 `->options()` accetta la **classe** dell'enum.
 *
 * `->options(WorkerType::class)` legge da solo `HasLabel`, `HasIcon` e `HasColor`.
 * Ricostruire l'array a mano — `foreach (Enum::cases() as $case) $out[$case->value]
 * = $case->label()` — produce codice che **funziona**: il select si popola, nessun
 * errore, nessun test rosso. Perde solo icone e colori, in silenzio.
 *
 * È per questo che serve una guardia e non una regola: un errore che non rompe
 * niente non viene trovato da nessun gate esistente.
 *
 * @see docs/wiki/rules/filament-enum-options.md
 */

/**
 * @return list<string>
 */
function xotPhpFilesUnderFilament(): array
{
    $files = [];
    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(base_path('Modules'), \FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if (! $fileInfo instanceof \SplFileInfo || $fileInfo->getExtension() !== 'php') {
            continue;
        }

        $path = $fileInfo->getPathname();

        // Solo codice di produzione: una fixture di test che costruisce options a
        // mano non disegna nessuna pagina, e questo file conterrebbe se stesso.
        if (! str_contains($path, '/Filament/') || str_contains($path, '/vendor/') || str_contains($path, '/tests/')) {
            continue;
        }

        $files[] = $path;
    }

    return $files;
}

test('nessuna classe Filament ricostruisce a mano le options di un enum', function (): void {
    $violations = [];

    foreach (xotPhpFilesUnderFilament() as $file) {
        $source = file_get_contents($file);

        // Un metodo che si chiama *Options e itera ::cases() e' la firma esatta
        // dell'anti-pattern. Il componente generico UI\EnumSelect e' l'eccezione
        // dichiarata: e' *il* posto dove la generazione sta di proposito.
        if (str_ends_with($file, 'Forms/Components/EnumSelect.php')) {
            continue;
        }

        $matches = [];
        preg_match_all('/function\s+\w*[Oo]ptions\s*\([^)]*\)[^{]*\{(.*?)\n    \}/s', $source, $matches);

        foreach ($matches[1] as $body) {
            if (str_contains((string) $body, '::cases()')) {
                $violations[] = str_replace(base_path().'/', '', $file);
                break;
            }
        }
    }

    Assert::assertSame(
        [],
        $violations,
        "In Filament 5 si passa la classe: ->options(MioEnum::class).\n".
        "Ricostruire l'array perde HasIcon e HasColor senza dare errore.\n- ".
        implode("\n- ", $violations)
    );
});

test('ogni enum passato a options() come array e dichiarato nella lista dei residui noti', function (): void {
    // `->options(Enum::options())` e `->options(Enum::labels())` sono la stessa
    // perdita vista dal lato del chiamante. Restano i casi in cui l'enum non
    // implementa ancora HasLabel: vanno convertiti, non tollerati per sempre.
    // Ogni riga qui e' debito dichiarato, tracciato da una story.
    $known = [
        // Modules/Notify: 3 enum senza HasLabel — story 18.30
        'Modules/Notify/app/Filament/Clusters/Test/Pages/SendWhatsAppPage.php',
    ];

    $found = [];

    foreach (xotPhpFilesUnderFilament() as $file) {
        $source = file_get_contents($file);
        $matches = [];

        if (preg_match_all('/->options\(\s*\\\\?[A-Z]\w*(?:Enum)?::(options|labels)\(\)/', $source, $matches) > 0) {
            $found[] = str_replace(base_path().'/', '', $file);
        }
    }

    sort($found);

    Assert::assertSame(
        $known,
        $found,
        "Elenco dei residui cambiato.\nSe hai convertito un file, toglilo da \$known.\n".
        "Se ne hai aggiunto uno, non farlo: passa la classe dell'enum.\nTrovati:\n- ".
        implode("\n- ", $found)
    );
});
