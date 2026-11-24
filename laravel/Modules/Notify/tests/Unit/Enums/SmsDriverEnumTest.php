<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Notify\Enums\SmsDriverEnum;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_implements;

uses(TestCase::class);
it('has correct cases', function (): void {
    Assert::assertCount(1, SmsDriverEnum::cases());

    Assert::assertSame('smsfactor', SmsDriverEnum::SMSFACTOR->value);
});

it('implements filament contracts', function (): void {
    $interfaces = class_implements(SmsDriverEnum::class) ?: [];

    Assert::assertArrayHasKey(HasLabel::class, $interfaces);
    Assert::assertArrayHasKey(HasIcon::class, $interfaces);
    Assert::assertArrayHasKey(HasColor::class, $interfaces);
});

it('has enum trait', function (): void {
    $reflection = new \ReflectionClass(SmsDriverEnum::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains('Modules\\Xot\\Traits\\EnumTrait', $traits);
});

it('get default returns default driver', function (): void {
    $default = SmsDriverEnum::getDefault();

    Assert::assertContains($default, SmsDriverEnum::cases());
    Assert::assertSame('smsfactor', $default->value);
});

it('each case has unique value', function (): void {
    $values = array_map(static fn (SmsDriverEnum $case): string => $case->value, SmsDriverEnum::cases());
    $uniqueValues = array_unique($values);

    Assert::assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
});

it('cases returns all enum instances', function (): void {
    $cases = SmsDriverEnum::cases();
    Assert::assertCount(1, $cases);
    Assert::assertSame('smsfactor', $cases[0]->value);
});

it('all cases expose non empty description', function (): void {
    foreach (SmsDriverEnum::cases() as $case) {
        Assert::assertNotEmpty($case->getDescription());
    }
});
