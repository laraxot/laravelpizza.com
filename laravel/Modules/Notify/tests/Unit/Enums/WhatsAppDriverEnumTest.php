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
        // @var mixed assertCount(4, WhatsAppDriverEnum::cases(;

        // @var mixed assertEquals('twilio', WhatsAppDriverEnum::TWILIO->value;
        // @var mixed assertEquals('messagebird', WhatsAppDriverEnum::MESSAGEBIRD->value;
        // @var mixed assertEquals('vonage', WhatsAppDriverEnum::VONAGE->value;
        // @var mixed assertEquals('infobip', WhatsAppDriverEnum::INFOBIP->value;
    }

    /** @test */
    public function options_returns_correct_array(): void
    {
        $options = WhatsAppDriverEnum::options();

        // @var mixed assertIsArray($options;
        // @var mixed assertCount(4, $options;
        // @var mixed assertEquals('Twilio', $options['twilio'];
        // @var mixed assertEquals('MessageBird', $options['messagebird'];
        // @var mixed assertEquals('Vonage', $options['vonage'];
        // @var mixed assertEquals('Infobip', $options['infobip'];
    }

    /** @test */
    public function labels_returns_localized_array(): void
    {
        $labels = WhatsAppDriverEnum::labels();

        // @var mixed assertIsArray($labels;
        // @var mixed assertCount(4, $labels;
        // @var mixed assertArrayHasKey('twilio', $labels;
        // @var mixed assertArrayHasKey('messagebird', $labels;
        // @var mixed assertArrayHasKey('vonage', $labels;
        // @var mixed assertArrayHasKey('infobip', $labels;
    }

    /** @test */
    public function is_supported_returns_true_for_valid_drivers(): void
    {
        // @var mixed assertTrue(WhatsAppDriverEnum::isSupported('twilio';
        // @var mixed assertTrue(WhatsAppDriverEnum::isSupported('messagebird';
        // @var mixed assertTrue(WhatsAppDriverEnum::isSupported('vonage';
        // @var mixed assertTrue(WhatsAppDriverEnum::isSupported('infobip';
    }

    /** @test */
    public function is_supported_returns_false_for_invalid_drivers(): void
    {
        // @var mixed assertFalse(WhatsAppDriverEnum::isSupported('invalid';
        // @var mixed assertFalse(WhatsAppDriverEnum::isSupported('';
        // @var mixed assertFalse(WhatsAppDriverEnum::isSupported('TWILIO';
        // @var mixed assertFalse(WhatsAppDriverEnum::isSupported('Twilio';
    }

    /** @test */
    public function get_default_returns_default_driver(): void
    {
        $default = WhatsAppDriverEnum::getDefault();

        // @var mixed assertInstanceOf(WhatsAppDriverEnum::class, $default;
        // @var mixed assertContains($default, WhatsAppDriverEnum::cases(;
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn ($case) => $case->value, WhatsAppDriverEnum::cases());
        $uniqueValues = array_unique($values);

        // @var mixed assertCount(count($values;
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = WhatsAppDriverEnum::cases();

        // @var mixed assertIsArray($cases;
        // @var mixed assertCount(4, $cases;

        foreach ($cases as $case) {
            // @var mixed assertInstanceOf(WhatsAppDriverEnum::class, $case;
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (WhatsAppDriverEnum::cases() as $case) {
            // @var mixed assertIsString($case->value;
        }
    }
}
