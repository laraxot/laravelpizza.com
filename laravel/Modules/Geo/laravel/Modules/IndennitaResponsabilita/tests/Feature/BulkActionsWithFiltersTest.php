<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;

/**
 * @param array<string, mixed>|null $tableFilters
 */
function indennitaResponsabilitaTemplateKey(?array $tableFilters): string
{
    $filters = $tableFilters ?? [];
    $annoValutatoreFilter = Arr::get($filters, 'anno/valutatore', []);

    if (! is_array($annoValutatoreFilter)) {
        return 'indennitaresponsabilita-';
    }

    $anno = Arr::get($annoValutatoreFilter, 'anno');

    return 'indennitaresponsabilita-'.(string) ($anno ?? '');
}

test('table bulk actions extracts anno from tableFilters using Arr::get', function (): void {
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
            'quadrimestre' => 1,
            'valutatore_id' => 10,
        ],
    ];

    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    Assert::assertIsArray($annoValutatoreFilter);

    Assert::assertSame(2026, Arr::get($annoValutatoreFilter, 'anno'));
});

test('table bulk actions returns null when tableFilters is empty', function (): void {
    Assert::assertNull(Arr::get([], 'anno/valutatore.anno'));
});

test('table bulk actions returns null when anno/valutatore key is missing', function (): void {
    $tableFilters = ['other_filter' => ['value' => 'test']];

    Assert::assertNull(Arr::get($tableFilters, 'anno/valutatore.anno'));
});

test('table bulk actions handles nested tableFilters correctly', function (): void {
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2025,
            'quadrimestre' => 2,
            'valutatore_id' => 20,
        ],
        'is_compiled' => true,
    ];

    Assert::assertSame('indennitaresponsabilita-2025', indennitaResponsabilitaTemplateKey($tableFilters));
});

test('table bulk actions generates correct template key when anno is present', function (): void {
    Assert::assertSame('indennitaresponsabilita-2026', indennitaResponsabilitaTemplateKey([
        'anno/valutatore' => ['anno' => 2026],
    ]));
});

test('table bulk actions generates template key with empty string when anno is null', function (): void {
    Assert::assertSame('indennitaresponsabilita-', indennitaResponsabilitaTemplateKey([
        'anno/valutatore' => ['quadrimestre' => 1],
    ]));
});

test('table bulk actions preserves all filter keys from tableFilters', function (): void {
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
            'quadrimestre' => 1,
            'valutatore_id' => 15,
        ],
        'is_compiled' => false,
    ];

    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    Assert::assertIsArray($annoValutatoreFilter);

    Assert::assertSame(1, Arr::get($annoValutatoreFilter, 'quadrimestre'));
    Assert::assertSame(15, Arr::get($annoValutatoreFilter, 'valutatore_id'));
    Assert::assertFalse(Arr::get($tableFilters, 'is_compiled'));
});

test('table bulk actions casts anno to string for template key correctly', function (): void {
    $tpl = indennitaResponsabilitaTemplateKey([
        'anno/valutatore' => ['anno' => 2026],
    ]);

    Assert::assertSame('indennitaresponsabilita-2026', $tpl);
    Assert::assertSame('2026', substr($tpl, -4));
});

test('table bulk actions handles non-array tableFilters gracefully', function (): void {
    Assert::assertSame('indennitaresponsabilita-', indennitaResponsabilitaTemplateKey(null));
});
