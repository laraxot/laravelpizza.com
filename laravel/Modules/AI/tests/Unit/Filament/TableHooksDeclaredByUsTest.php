<?php

declare(strict_types=1);
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class)->group('no-db');

/*
 * Story 16.12 — i punti di estensione di Xot portano gli stessi nomi che Filament 5 ha
 * deprecato (`getTableColumns`, `getTableFilters`, ...). La conseguenza pericolosa non e'
 * il rumore di PHPStan: e' che lo stub deprecato di Filament **soddisfa** il metodo
 * astratto dichiarato da `HasXotTable` e ritorna un array vuoto.
 *
 * Una classe che si dimentica di implementare `getTableColumns()` non ottiene quindi un
 * errore: ottiene una tabella senza colonne, senza log e senza eccezioni. Questi test
 * rendono rumoroso quel caso, ed esistono per restare rossi finche' la rinomina degli
 * hook non chiude la collisione di nomi alla radice.
 */

/**
 * @return list<class-string>
 */
function xotTableHookUsers(): array
{
    $classes = [];

    foreach (get_declared_classes() as $class) {
        if (! str_starts_with($class, 'Modules\\')) {
            continue;
        }

        if (! in_array(HasXotTable::class, class_uses_recursive($class), true)) {
            continue;
        }

        $reflection = new ReflectionClass($class);

        if ($reflection->isAbstract()) {
            continue;
        }

        $classes[] = $class;
    }

    return $classes;
}

test('ogni classe concreta che usa HasXotTable dichiara i propri hook di tabella', function (): void {
    $hooks = ['getTableColumns', 'getTableFilters'];
    $stolenFromFilament = [];

    foreach (xotTableHookUsers() as $class) {
        foreach ($hooks as $hook) {
            if (! method_exists($class, $hook)) {
                continue;
            }

            $declaring = (new ReflectionMethod($class, $hook))->getDeclaringClass()->getName();

            if (str_starts_with($declaring, 'Filament\\')) {
                $stolenFromFilament[] = $class.'::'.$hook.'() ereditato da '.$declaring;
            }
        }
    }

    Assert::assertSame(
        [],
        $stolenFromFilament,
        "Questi hook risolvono allo stub deprecato di Filament, che ritorna array vuoto:\n"
        .implode("\n", $stolenFromFilament)
        ."\nUna tabella senza colonne, senza errori. Implementare l'hook nella classe. Story 16.12.",
    );
});

test('HasXotTable dichiara getTableColumns astratto, quindi lo stub di Filament puo soddisfarlo', function (): void {
    $source = (string) file_get_contents(
        (string) (new ReflectionClass(HasXotTable::class))->getFileName()
    );

    Assert::assertStringContainsString(
        'abstract protected function getTableColumns(): array;',
        $source,
        'Se questa dichiarazione sparisce, la trappola descritta dalla story 16.12 e cambiata: '
        .'rileggere il test prima di aggiornarlo.',
    );
});
