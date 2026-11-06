<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;
use function Safe\glob;

uses(TestCase::class);

/**
 * Nessuna chiamata di debug reale nel codice dei moduli (cartella `app` di ogni modulo).
 *
 * `dddx()` (Modules/Xot/helpers/Helper.php) termina con `dd()`: una sola chiamata
 * dimenticata in un percorso vivo scarica i dati e uccide la richiesta. Il 2026-10-20 ce
 * n'erano 67; il 2026-11-04 le ultime 3 in percorsi vivi (S3Test, Media ConvertAction,
 * Xot Update\PivotAction). Una regola senza test torna indietro al primo merge.
 *
 * Si usa il tokenizer, non `rg`: commenti, stringhe e metodi omonimi (`$this->dd()`,
 * `function dd()`) gonfiano il conteggio, e `rg` con lookahead senza `-P` da' falsi zeri.
 *
 * Fuori scopo di proposito: `helpers/` (qui vive la definizione di `dddx()`), `tests/`
 * e i file Blade.
 *
 * @see docs/stories/wave0-repository-recovery-lock-and-debug-calls.story.md
 */
const DEBUG_FUNCTION_NAMES = ['dd', 'ddd', 'dddx', 'dump', 'ray', 'var_dump'];

/**
 * @return list<string>
 */
function moduleAppPhpFiles(): array
{
    $files = [];

    foreach (glob(base_path('Modules/*/app')) as $appDir) {
        Assert::string($appDir);

        $iterator = new RecursiveIteratorIterator(new RecursiveCallbackFilterIterator(
            new RecursiveDirectoryIterator($appDir, \FilesystemIterator::SKIP_DOTS),
            static fn (SplFileInfo $entry): bool => ! ($entry->isDir() && in_array($entry->getFilename(), ['vendor', 'node_modules'], true)),
        ));

        foreach ($iterator as $entry) {
            if ($entry instanceof SplFileInfo && $entry->isFile() && $entry->getExtension() === 'php' && ! str_ends_with($entry->getFilename(), '.blade.php')) {
                $files[] = $entry->getPathname();
            }
        }
    }

    sort($files);

    return $files;
}

/**
 * @return list<array{int, string}> coppie [riga, nome funzione]
 */
function debugCallsIn(string $code): array
{
    $tokens = token_get_all($code);
    $count = count($tokens);
    $hits = [];

    for ($i = 0; $i < $count; $i++) {
        $token = $tokens[$i];

        if (! is_array($token) || $token[0] !== T_STRING || ! in_array(strtolower($token[1]), DEBUG_FUNCTION_NAMES, true)) {
            continue;
        }

        $next = $i + 1;
        while ($next < $count && is_array($tokens[$next]) && $tokens[$next][0] === T_WHITESPACE) {
            $next++;
        }

        if (($tokens[$next] ?? null) !== '(') {
            continue;
        }

        $prev = $i - 1;
        while ($prev >= 0 && is_array($tokens[$prev]) && $tokens[$prev][0] === T_WHITESPACE) {
            $prev--;
        }

        $before = $tokens[$prev] ?? null;
        $isMemberOrDeclaration = is_array($before) && in_array(
            $before[0],
            [T_OBJECT_OPERATOR, T_NULLSAFE_OBJECT_OPERATOR, T_DOUBLE_COLON, T_FUNCTION, T_NEW],
            true,
        );

        if (! $isMemberOrDeclaration) {
            $hits[] = [$token[2], strtolower($token[1])];
        }
    }

    return $hits;
}

test('il rilevatore ignora commenti, stringhe, metodi e dichiarazioni e vede solo la chiamata vera', function (): void {
    $code = <<<'PHP'
<?php
// dddx($a);
/* dd($b); */
$s = 'dd($c)';
class P {
    public function dd($x) {}
    public function run() { $this->dd(1); self::dump(2); }
}
function ping() { return 1; }
dddx(['reale' => true]);
PHP;

    expect(debugCallsIn($code))->toBe([[10, 'dddx']]);
});

test('nessun file nella cartella app dei moduli contiene una chiamata di debug reale', function (): void {
    $offenders = [];

    foreach (moduleAppPhpFiles() as $file) {
        $code = file_get_contents($file);

        foreach (debugCallsIn($code) as [$line, $name]) {
            $offenders[] = str_replace(base_path().'/', '', $file).':'.$line.' '.$name.'()';
        }
    }

    expect($offenders)->toBe([], "Chiamate di debug nel codice dei moduli:\n".implode("\n", $offenders));
});
