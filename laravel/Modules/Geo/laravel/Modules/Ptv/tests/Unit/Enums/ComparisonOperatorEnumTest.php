<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Enums;

use Modules\Ptv\Enums\ComparisonOperatorEnum;
use Modules\Ptv\Enums\RuleValueTypeEnum;
use Modules\Ptv\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('ComparisonOperatorEnum', function (): void {
    it('uses EnumTrait and exposes SQL operators', function (): void {
        $traits = class_uses(ComparisonOperatorEnum::class);

        Assert::assertContains('Modules\\Xot\\Traits\\EnumTrait', $traits);
        Assert::assertCount(8, ComparisonOperatorEnum::cases());
        Assert::assertSame('=', ComparisonOperatorEnum::Equal->value);
        Assert::assertSame('NOT LIKE', ComparisonOperatorEnum::NotLike->value);
    });

    it('resolves labels from lang values', function (): void {
        Assert::assertSame('Uguale a', ComparisonOperatorEnum::Equal->getLabel());
        Assert::assertSame('Non contiene', ComparisonOperatorEnum::NotLike->getLabel());
    });
});

describe('RuleValueTypeEnum', function (): void {
    it('uses EnumTrait and exposes value types', function (): void {
        $traits = class_uses(RuleValueTypeEnum::class);

        Assert::assertContains('Modules\\Xot\\Traits\\EnumTrait', $traits);
        Assert::assertCount(4, RuleValueTypeEnum::cases());
        Assert::assertSame('string', RuleValueTypeEnum::String->value);
    });

    it('resolves labels from lang values', function (): void {
        Assert::assertSame('Stringa', RuleValueTypeEnum::String->getLabel());
        Assert::assertSame('Lista', RuleValueTypeEnum::List->getLabel());
    });
});
