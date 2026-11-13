<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Filament;

<<<<<<< .merge_file_gi7ldJ
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

test('ListLogActivities toTranslationString normalizza stringhe e array', function (): void {
    $page = new class() extends ListLogActivities
    {
        public static function getResource(): string
        {
            return ActivityResource::class;
        }

        public function exposeToTranslationString(mixed $value): string
        {
            $method = new ReflectionMethod(ListLogActivities::class, 'toTranslationString');
            $method->setAccessible(true);

            /** @var string $result */
            $result = $method->invoke($this, $value);

            return $result;
        }
    };
=======
use Modules\Activity\Tests\Fixtures\ListLogActivitiesTranslationHarness;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ListLogActivities toTranslationString normalizza stringhe e array', function (): void {
    $page = new ListLogActivitiesTranslationHarness;
>>>>>>> .merge_file_qBdmRj

    Assert::assertSame('Titolo semplice', $page->exposeToTranslationString('Titolo semplice'));
    Assert::assertSame('parte uno parte due', $page->exposeToTranslationString(['parte uno', 'parte due']));
    Assert::assertSame('', $page->exposeToTranslationString(123));
});

test('ListLogActivities getFieldLabel usa fallback per chiavi sconosciute', function (): void {
<<<<<<< .merge_file_gi7ldJ
    $page = new class() extends ListLogActivities
    {
        public static function getResource(): string
        {
            return ActivityResource::class;
        }
    };
=======
    $page = new ListLogActivitiesTranslationHarness;
>>>>>>> .merge_file_qBdmRj

    Assert::assertSame('campo_custom', $page->getFieldLabel('campo_custom'));
});
