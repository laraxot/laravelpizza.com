<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Filament;

use Modules\Activity\Tests\Fixtures\ListLogActivitiesTranslationHarness;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ListLogActivities stringifyTranslationValue normalizza stringhe e array', function (): void {
    $page = new ListLogActivitiesTranslationHarness;

    Assert::assertSame('Titolo semplice', $page->exposeStringifyTranslationValue('Titolo semplice'));
    Assert::assertSame('parte uno parte due', $page->exposeStringifyTranslationValue(['parte uno', 'parte due']));
    // Gli scalari diventano stringa: le label di traduzione possono essere numeri (es. 'sort').
    Assert::assertSame('123', $page->exposeStringifyTranslationValue(123));
});

test('ListLogActivities getFieldLabel usa fallback per chiavi sconosciute', function (): void {
    $page = new ListLogActivitiesTranslationHarness;

    Assert::assertSame('campo_custom', $page->getFieldLabel('campo_custom'));
});
