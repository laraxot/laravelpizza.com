<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Datas\Concerns;

use Modules\Xot\Contracts\YearsConfigContract;
use Modules\Xot\Datas\Concerns\HasYearsConfig;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * HasYearsConfig e' usato dalle `{Modulo}ConfigData` dei moduli applicativi (Ptv, Progressioni, ...), che non
 * stanno in tutte le installazioni: qui lo si esercita con un'implementazione minima, cosi' resta analizzato.
 */
final class YearsConfigFixture implements YearsConfigContract
{
    use HasYearsConfig;

    /**
     * @param  array<array-key, mixed>  $properties
     * @return array<array-key, mixed>
     */
    public static function prepare(array $properties): array
    {
        return static::prepareAnni($properties);
    }
}

describe('HasYearsConfig', function (): void {
    test('proposes the last three years when the tenant file has no `anni`', function (): void {
        $year = (int) date('Y');

        Assert::assertSame([$year - 2, $year - 1, $year], YearsConfigFixture::prepare([])['anni']);
    });

    test('normalises the years written by hand or by TagsInput: unique integers, ascending', function (): void {
        $prepared = YearsConfigFixture::prepare(['anni' => ['2025', ' 2023 ', 2024, '2025', 'abc', 20.5, null]]);

        Assert::assertSame([2023, 2024, 2025], $prepared['anni']);
    });

    test('keeps the other properties untouched', function (): void {
        $prepared = YearsConfigFixture::prepare(['name' => 'Ptv', 'anni' => [2024]]);

        Assert::assertSame('Ptv', $prepared['name']);
    });

    test('offers the years as select options, most recent first', function (): void {
        $config = new YearsConfigFixture;
        $config->anni = [2023, 2024, 2025];

        Assert::assertSame([2025 => '2025', 2024 => '2024', 2023 => '2023'], $config->getAnniOptions());
    });
});
