<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament;

use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Tests\TestCase;
use ReflectionClass;

use function Safe\file_get_contents;

uses(TestCase::class);

/**
 * Guardia della regola docs/wiki/rules/xot-table-method-names.md:
 * `table()` non decide, chiede — e lo chiede direttamente all'hook.
 *
 * La story 5.53 era gia' stata chiusa una volta: un lavoro concorrente ha
 * reintrodotto i `resolve*` e gli enum inline. Questo test rende meccanica
 * una disciplina che finora era affidata alla memoria degli agenti.
 */
test('HasXotTable non dichiara metodi resolve*', function (): void {
    $methods = array_map(
        static fn (\ReflectionMethod $m): string => $m->getName(),
        (new ReflectionClass(HasXotTable::class))->getMethods(),
    );

    $offenders = array_values(array_filter(
        $methods,
        static fn (string $name): bool => str_starts_with($name, 'resolve'),
    ));

    // Il dispatch lo fa gia' PHP con l'override: nessun resolver a reflection.
    expect($offenders)->toBe([]);
});

test('table() non contiene valori hardcoded fra i setter', function (): void {
    $source = file_get_contents(
        (string) (new ReflectionClass(HasXotTable::class))->getFileName()
    );

    $start = strpos($source, 'public function table(');
    expect($start)->not->toBeFalse();

    $body = substr($source, (int) $start, 3000);

    foreach (['FiltersLayout::', 'RecordActionsPosition::'] as $literal) {
        // Enum inline in table(): usare un hook get* con default nel trait.
        expect(str_contains($body, $literal))->toBeFalse();
    }
});

test('gli hook di azione non sono avvolti in array_values()', function (): void {
    $source = file_get_contents(
        (string) (new ReflectionClass(HasXotTable::class))->getFileName()
    );

    foreach ([
        'headerActions',
        'recordActions',
        'toolbarActions',
        'emptyStateActions',
    ] as $setter) {
        // Filament reindicizza da solo in push*(): array_values() al chiamante e' rumore.
        expect(str_contains($source, "->{$setter}(array_values("))->toBeFalse();
    }
});
