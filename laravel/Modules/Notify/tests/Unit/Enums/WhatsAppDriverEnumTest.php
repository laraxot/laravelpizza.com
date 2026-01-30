<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\WhatsAppDriverEnum;
use PHPUnit\Framework\TestCase;

class WhatsAppDriverEnumTest extends TestCase
{
    /** @test */
    public function it_has_correct_cases(): void
    {
        $this->assertCount(4, WhatsAppDriverEnum::cases());

        $this->assertEquals('twilio', WhatsAppDriverEnum::TWILIO->value);
        $this->assertEquals('messagebird', WhatsAppDriverEnum::MESSAGEBIRD->value);
        $this->assertEquals('vonage', WhatsAppDriverEnum::VONAGE->value);
        $this->assertEquals('infobip', WhatsAppDriverEnum::INFOBIP->value);
    }

    /** @test */
    public function options_returns_correct_array(): void
    {
        $options = WhatsAppDriverEnum::options();

        $this->assertIsArray($options);
        $this->assertCount(4, $options);
        $this->assertEquals('Twilio', $options['twilio']);
        $this->assertEquals('MessageBird', $options['messagebird']);
        $this->assertEquals('Vonage', $options['vonage']);
        $this->assertEquals('Infobip', $options['infobip']);
    }

    /** @test */
    public function labels_returns_localized_array(): void
    {
        $labels = WhatsAppDriverEnum::labels();

        $this->assertIsArray($labels);
        $this->assertCount(4, $labels);
        $this->assertArrayHasKey('twilio', $labels);
        $this->assertArrayHasKey('messagebird', $labels);
        $this->assertArrayHasKey('vonage', $labels);
        $this->assertArrayHasKey('infobip', $labels);
    }

    /** @test */
    public function is_supported_returns_true_for_valid_drivers(): void
    {
        $this->assertTrue(WhatsAppDriverEnum::isSupported('twilio'));
        $this->assertTrue(WhatsAppDriverEnum::isSupported('messagebird'));
        $this->assertTrue(WhatsAppDriverEnum::isSupported('vonage'));
        $this->assertTrue(WhatsAppDriverEnum::isSupported('infobip'));
    }

    /** @test */
    public function is_supported_returns_false_for_invalid_drivers(): void
    {
        $this->assertFalse(WhatsAppDriverEnum::isSupported('invalid'));
        $this->assertFalse(WhatsAppDriverEnum::isSupported(''));
        $this->assertFalse(WhatsAppDriverEnum::isSupported('TWILIO'));
        $this->assertFalse(WhatsAppDriverEnum::isSupported('Twilio'));
    }

    /** @test */
    public function get_default_returns_default_driver(): void
    {
        $default = WhatsAppDriverEnum::getDefault();

        $this->assertInstanceOf(WhatsAppDriverEnum::class, $default);
        $this->assertContains($default, WhatsAppDriverEnum::cases());
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn($case) => $case->value, WhatsAppDriverEnum::cases());
        $uniqueValues = array_unique($values);

        $this->assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = WhatsAppDriverEnum::cases();

        $this->assertIsArray($cases);
        $this->assertCount(4, $cases);

        foreach ($cases as $case) {
            $this->assertInstanceOf(WhatsAppDriverEnum::class, $case);
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (WhatsAppDriverEnum::cases() as $case) {
            $this->assertIsString($case->value);
        }
    }
}
