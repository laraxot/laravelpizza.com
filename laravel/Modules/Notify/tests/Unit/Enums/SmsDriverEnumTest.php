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
<<<<<<< HEAD

    /** @test */
    public function it_has_trans_trait(): void
    {
        $reflection = new ReflectionClass(SmsDriverEnum::class);
        $traits = $reflection->getTraitNames();

        $this->assertContains('Modules\Xot\Filament\Traits\TransTrait', $traits);
    }

    /** @test */
    public function it_has_required_methods(): void
    {
        $this->assertTrue(method_exists(SmsDriverEnum::class, 'getLabel'));
        $this->assertTrue(method_exists(SmsDriverEnum::class, 'getColor'));
        $this->assertTrue(method_exists(SmsDriverEnum::class, 'getIcon'));
        $this->assertTrue(method_exists(SmsDriverEnum::class, 'getDescription'));
        $this->assertTrue(method_exists(SmsDriverEnum::class, 'getDefault'));
    }

    /** @test */
    public function get_default_returns_default_driver(): void
    {
        $default = SmsDriverEnum::getDefault();

        $this->assertInstanceOf(SmsDriverEnum::class, $default);
        $this->assertContains($default, SmsDriverEnum::cases());
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn ($case) => $case->value, SmsDriverEnum::cases());
        $uniqueValues = array_unique($values);

        $this->assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = SmsDriverEnum::cases();

        $this->assertIsArray($cases);
        $this->assertCount(7, $cases);

        foreach ($cases as $case) {
            $this->assertInstanceOf(SmsDriverEnum::class, $case);
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (SmsDriverEnum::cases() as $case) {
            $this->assertIsString($case->getLabel());
            $this->assertIsString($case->getColor());
            $this->assertIsString($case->getIcon());
            $this->assertIsString($case->getDescription());
        }
    }
}
=======
});
>>>>>>> 40b96bcd6 (.)
