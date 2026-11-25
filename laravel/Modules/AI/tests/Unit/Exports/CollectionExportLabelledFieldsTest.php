<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Modules\Xot\Exports\CollectionExport;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/**
 * TKey/TValue di Collection sono invarianti: il costruttore di CollectionExport
 * chiede `Collection<int|string, mixed>`, non `Collection<int, array<...>>`.
 *
 * @return Collection<int|string, mixed>
 */
function labelledRows(): Collection
{
    /** @var Collection<int|string, mixed> $rows */
    $rows = collect([
        [
            'matr' => 7,
            'ratings_by_id' => [
                52 => [
                    'pivot' => [
                        'value' => 57,
                    ],
                ],
            ],
        ],
    ]);

    return $rows;
}

describe('CollectionExport campi con intestazione esplicita', function (): void {
    test('una lista di campi resta com\'era: intestazione = campo', function (): void {
        $export = new CollectionExport(labelledRows(), null, ['matr']);

        expect($export->headings())->toBe(['matr']);
        expect($export->map(labelledRows()->first()))->toBe(['7']);
    });

    test('una chiave stringa e\' il percorso, il valore e\' l\'intestazione', function (): void {
        $export = new CollectionExport(labelledRows(), null, [
            'matr',
            'ratings_by_id.52.pivot.value' => 'Obiettivo A',
        ]);

        expect($export->headings())->toBe(['matr', 'Obiettivo A']);
        expect($export->map(labelledRows()->first()))->toBe(['7', '57']);
    });

    test('l\'intestazione esplicita non passa dalla traduzione, quella implicita si\'', function (): void {
        $export = new CollectionExport(labelledRows(), 'xot::inesistente.fields', [
            'matr',
            'ratings_by_id.52.pivot.value' => 'Obiettivo A',
        ]);

        expect($export->headings())->toBe(['matr', 'Obiettivo A']);
    });

    test('un percorso assente esporta una cella vuota, non salta la colonna', function (): void {
        $export = new CollectionExport(labelledRows(), null, [
            'ratings_by_id.99.pivot.value' => 'Obiettivo Z',
            'matr',
        ]);

        expect($export->map(labelledRows()->first()))->toBe(['', '7']);
    });
});
