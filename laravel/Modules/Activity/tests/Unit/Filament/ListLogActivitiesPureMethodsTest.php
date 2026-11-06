<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Filament;

use Modules\Activity\Tests\Fixtures\ListLogActivitiesTranslationHarness;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ListLogActivities toTranslationString normalizza stringhe e array', function (): void {
    $page = new ListLogActivitiesTranslationHarness;

    Assert::assertSame('Titolo semplice', $page->exposeToTranslationString('Titolo semplice'));
    Assert::assertSame('parte uno parte due', $page->exposeToTranslationString(['parte uno', 'parte due']));
    Assert::assertSame('', $page->exposeToTranslationString(123));
});

test('ListLogActivities getFieldLabel usa fallback per chiavi sconosciute', function (): void {
    $page = new ListLogActivitiesTranslationHarness;

    Assert::assertSame('campo_custom', $page->getFieldLabel('campo_custom'));
});
