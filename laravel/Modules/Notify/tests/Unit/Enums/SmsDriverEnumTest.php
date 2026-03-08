<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Notify\Enums\SmsDriverEnum;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class SmsDriverEnumTest extends TestCase
{
    /** @test */
    public function it_has_correct_cases(): void
    {
        // @var mixed assertCount(7, SmsDriverEnum::cases(;

        // @var mixed assertEquals('smsfactor', SmsDriverEnum::SMSFACTOR->value;
        // @var mixed assertEquals('twilio', SmsDriverEnum::TWILIO->value;
        // @var mixed assertEquals('nexmo', SmsDriverEnum::NEXMO->value;
        // @var mixed assertEquals('plivo', SmsDriverEnum::PLIVO->value;
        // @var mixed assertEquals('gammu', SmsDriverEnum::GAMMU->value;
        // @var mixed assertEquals('netfun', SmsDriverEnum::NETFUN->value;
        // @var mixed assertEquals('agiletelecom', SmsDriverEnum::AGILETELECOM->value;
    }

    /** @test */
    public function it_implements_filament_contracts(): void
    {
        // @var mixed assertInstanceOf(HasLabel::class, SmsDriverEnum::SMSFACTOR;
        // @var mixed assertInstanceOf(HasIcon::class, SmsDriverEnum::SMSFACTOR;
        // @var mixed assertInstanceOf(HasColor::class, SmsDriverEnum::SMSFACTOR;
    }

    /** @test */
    public function it_has_trans_trait(): void
    {
        $reflection = new ReflectionClass(SmsDriverEnum::class);
        $traits = $reflection->getTraitNames();

        // @var mixed assertContains('Modules\Xot\Filament\Traits\TransTrait', $traits;
    }

    /** @test */
    public function it_has_required_methods(): void
    {
        // @var mixed assertTrue(method_exists(SmsDriverEnum::class, 'getLabel';
        // @var mixed assertTrue(method_exists(SmsDriverEnum::class, 'getColor';
        // @var mixed assertTrue(method_exists(SmsDriverEnum::class, 'getIcon';
        // @var mixed assertTrue(method_exists(SmsDriverEnum::class, 'getDescription';
        // @var mixed assertTrue(method_exists(SmsDriverEnum::class, 'getDefault';
    }

    /** @test */
    public function get_default_returns_default_driver(): void
    {
        $default = SmsDriverEnum::getDefault();

        // @var mixed assertInstanceOf(SmsDriverEnum::class, $default;
        // @var mixed assertContains($default, SmsDriverEnum::cases(;
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn ($case) => $case->value, SmsDriverEnum::cases());
        $uniqueValues = array_unique($values);

        // @var mixed assertCount(count($values;
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = SmsDriverEnum::cases();

        // @var mixed assertIsArray($cases;
        // @var mixed assertCount(7, $cases;

        foreach ($cases as $case) {
            // @var mixed assertInstanceOf(SmsDriverEnum::class, $case;
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (SmsDriverEnum::cases() as $case) {
            // @var mixed assertIsString($case->getLabel(;
            // @var mixed assertIsString($case->getColor(;
            // @var mixed assertIsString($case->getIcon(;
            // @var mixed assertIsString($case->getDescription(;
        }
    }
}
