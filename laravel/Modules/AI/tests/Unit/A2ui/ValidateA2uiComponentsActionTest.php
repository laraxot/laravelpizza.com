<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\A2ui;

use Modules\AI\Actions\A2ui\ValidateA2uiComponentsAction;
use Modules\AI\Tests\TestCase;

uses(TestCase::class);

/**
 * @param  array<int, mixed>  $components
 * @return list<string>
 */
function a2uiErrors(array $components): array
{
    return app(ValidateA2uiComponentsAction::class)->execute($components);
}

/** @return list<array<string, mixed>> */
function validA2uiTree(): array
{
    return [
        ['id' => 'root', 'component' => 'Column', 'children' => ['kpis', 'chart', 'table']],
        ['id' => 'kpis', 'component' => 'Row', 'children' => ['k1', 'k2']],
        ['id' => 'k1', 'component' => 'Stat', 'label' => 'Domande', 'value' => 42, 'trend' => '+12%', 'weight' => 1],
        ['id' => 'k2', 'component' => 'Stat', 'label' => 'Risolte', 'value' => '87%', 'weight' => 1],
        ['id' => 'chart', 'component' => 'Chart', 'title' => 'Per giorno', 'type' => 'bar', 'labels' => ['lun', 'mar'],
            'datasets' => [['label' => 'Domande', 'data' => [3, 4.5]]]],
        ['id' => 'table', 'component' => 'DataTable', 'columns' => ['Domanda', 'Volte'], 'rows' => [['Consegne?', 6]]],
    ];
}

it('accetta un albero valido', function (): void {
    expect(a2uiErrors(validA2uiTree()))->toBe([]);
});

it('vuole una lista non vuota di componenti noti con id univoci', function (): void {
    expect(a2uiErrors([]))->not->toBe([])
        ->and(a2uiErrors([['id' => 'root', 'component' => 'Iframe']]))->not->toBe([])
        ->and(a2uiErrors([['id' => 'root', 'component' => 'Divider'], ['id' => 'root', 'component' => 'Divider']]))->not->toBe([]);
});

it('vuole la radice', function (): void {
    expect(a2uiErrors([['id' => 'a', 'component' => 'Divider']]))->toContain('Manca il componente con id "root".');
});

it('rifiuta proprieta\' in piu\' nei componenti personalizzati', function (): void {
    $errors = a2uiErrors([['id' => 'root', 'component' => 'Stat', 'label' => 'X', 'value' => 1, 'color' => 'red']]);

    expect($errors)->toBe(['root: proprietà non previste: color.']);
});

it('vuole un valore per etichetta nei grafici e una cella per colonna nelle tabelle', function (): void {
    $chart = ['id' => 'root', 'component' => 'Chart', 'title' => 'T', 'type' => 'bar', 'labels' => ['a', 'b'], 'datasets' => [['label' => 'L', 'data' => [1]]]];
    $table = ['id' => 'root', 'component' => 'DataTable', 'columns' => ['a', 'b'], 'rows' => [['solo una']]];

    expect(a2uiErrors([$chart]))->not->toBe([])
        ->and(a2uiErrors([$table]))->not->toBe([])
        ->and(a2uiErrors([[...$chart, 'type' => 'radar', 'datasets' => [['label' => 'L', 'data' => [1, 2]]]]]))->not->toBe([]);
});

it('segnala figli mancanti, doppi genitori e cicli sulla radice', function (): void {
    $errors = a2uiErrors([
        ['id' => 'root', 'component' => 'Column', 'children' => ['a', 'ghost']],
        ['id' => 'a', 'component' => 'Card', 'child' => 'root'],
        ['id' => 'b', 'component' => 'Row', 'children' => ['a']],
    ]);

    expect($errors)->toContain('root: il figlio "ghost" non esiste.')
        ->toContain('a: "root" ha già un genitore.')
        ->toContain('b: "a" ha già un genitore.');
});
