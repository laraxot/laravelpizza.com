<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Enums\SupportedLocale;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('espone i due locali supportati', function (): void {
    Assert::assertSame(['it', 'en'], array_column(SupportedLocale::cases(), 'value'));
});

test('fromString risolve i valori noti', function (): void {
    /** @var list<array{0: string, 1: SupportedLocale}> $casi */
    $casi = [
        ['it', SupportedLocale::IT],
        ['en', SupportedLocale::EN],
    ];

    foreach ($casi as [$value, $expected]) {
        Assert::assertSame($expected, SupportedLocale::fromString($value));
    }
});

test('fromString ricade su IT per i valori sconosciuti', function (): void {
    /** @var list<string> $valoriSconosciuti */
    $valoriSconosciuti = ['', 'fr', 'IT', 'it-IT', 'qualsiasi-cosa'];

    foreach ($valoriSconosciuti as $value) {
        Assert::assertSame(SupportedLocale::IT, SupportedLocale::fromString($value));
    }
});

test('getLabel restituisce la traduzione, non la chiave', function (): void {
    /** @var list<array{0: SupportedLocale, 1: string}> $casi */
    $casi = [
        [SupportedLocale::IT, 'Italiano'],
        [SupportedLocale::EN, 'Inglese'],
    ];

    foreach ($casi as [$locale, $expected]) {
        $label = $locale->getLabel();

        Assert::assertSame($expected, $label);
        Assert::assertStringStartsNotWith('fix:', $label, 'prefisso fix: = traduzione mancante in lang/');
    }
});

test('toArray indicizza i casi per valore', function (): void {
    $locales = SupportedLocale::toArray();

    Assert::assertArrayHasKey('it', $locales);
    Assert::assertArrayHasKey('en', $locales);
    Assert::assertCount(2, $locales);
});
