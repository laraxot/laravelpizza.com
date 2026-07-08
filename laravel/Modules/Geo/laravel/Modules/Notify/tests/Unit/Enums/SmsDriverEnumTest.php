<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Notify\Enums\SmsDriverEnum;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('has correct cases', function (): void {
    Assert::assertCount(1, SmsDriverEnum::cases());

    Assert::assertSame('smsfactor', SmsDriverEnum::SMSFACTOR->value);
});

it('implements filament contracts', function (): void {
    Assert::assertInstanceOf(HasLabel::class, SmsDriverEnum::SMSFACTOR);
    Assert::assertInstanceOf(HasIcon::class, SmsDriverEnum::SMSFACTOR);
    Assert::assertInstanceOf(HasColor::class, SmsDriverEnum::SMSFACTOR);
});

it('has enum trait', function (): void {
    $reflection = new \ReflectionClass(SmsDriverEnum::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains('Modules\\Xot\\Traits\\EnumTrait', $traits);
});

it('get default returns default driver', function (): void {
    $default = SmsDriverEnum::getDefault();

    Assert::assertInstanceOf(SmsDriverEnum::class, $default);
    Assert::assertContains($default, SmsDriverEnum::cases());
});

it('each case has unique value', function (): void {
    $values = array_map(static fn ($case) => $case->value, SmsDriverEnum::cases());
    $uniqueValues = array_unique($values);

    Assert::assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
});

it('cases returns all enum instances', function (): void {
    $cases = SmsDriverEnum::cases();
    Assert::assertCount(1, $cases);

    foreach ($cases as $case) {
        Assert::assertInstanceOf(SmsDriverEnum::class, $case);
    }
});

it('all cases expose non empty description', function (): void {
    foreach (SmsDriverEnum::cases() as $case) {
        Assert::assertNotEmpty($case->getDescription());
    }
});
