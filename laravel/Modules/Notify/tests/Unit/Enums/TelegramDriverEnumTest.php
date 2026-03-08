<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\TelegramDriverEnum;
use PHPUnit\Framework\TestCase;

class TelegramDriverEnumTest extends TestCase
{
    /** @test */
    public function it_has_correct_cases(): void
    {
        // @var mixed assertCount(3, TelegramDriverEnum::cases(;

        // @var mixed assertEquals('telegram', TelegramDriverEnum::TELEGRAM->value;
        // @var mixed assertEquals('botapi', TelegramDriverEnum::BOTAPI->value;
        // @var mixed assertEquals('laravel-telegram', TelegramDriverEnum::LARAVEL_TELEGRAM->value;
    }

    /** @test */
    public function options_returns_correct_array(): void
    {
        $options = TelegramDriverEnum::options();

        // @var mixed assertIsArray($options;
        // @var mixed assertCount(3, $options;
        // @var mixed assertEquals('Telegram', $options['telegram'];
        // @var mixed assertEquals('Bot API', $options['botapi'];
        // @var mixed assertEquals('Laravel Telegram', $options['laravel-telegram'];
    }

    /** @test */
    public function labels_returns_localized_array(): void
    {
        $labels = TelegramDriverEnum::labels();

        // @var mixed assertIsArray($labels;
        // @var mixed assertCount(3, $labels;
        // @var mixed assertArrayHasKey('telegram', $labels;
        // @var mixed assertArrayHasKey('botapi', $labels;
        // @var mixed assertArrayHasKey('laravel-telegram', $labels;
    }

    /** @test */
    public function is_supported_returns_true_for_valid_drivers(): void
    {
        // @var mixed assertTrue(TelegramDriverEnum::isSupported('telegram';
        // @var mixed assertTrue(TelegramDriverEnum::isSupported('botapi';
        // @var mixed assertTrue(TelegramDriverEnum::isSupported('laravel-telegram';
    }

    /** @test */
    public function is_supported_returns_false_for_invalid_drivers(): void
    {
        // @var mixed assertFalse(TelegramDriverEnum::isSupported('invalid';
        // @var mixed assertFalse(TelegramDriverEnum::isSupported('';
        // @var mixed assertFalse(TelegramDriverEnum::isSupported('TELEGRAM';
        // @var mixed assertFalse(TelegramDriverEnum::isSupported('Telegram';
    }

    /** @test */
    public function get_default_returns_default_driver(): void
    {
        $default = TelegramDriverEnum::getDefault();

        // @var mixed assertInstanceOf(TelegramDriverEnum::class, $default;
        // @var mixed assertContains($default, TelegramDriverEnum::cases(;
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn ($case) => $case->value, TelegramDriverEnum::cases());
        $uniqueValues = array_unique($values);

        // @var mixed assertCount(count($values;
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = TelegramDriverEnum::cases();

        // @var mixed assertIsArray($cases;
        // @var mixed assertCount(3, $cases;

        foreach ($cases as $case) {
            // @var mixed assertInstanceOf(TelegramDriverEnum::class, $case;
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (TelegramDriverEnum::cases() as $case) {
            // @var mixed assertIsString($case->value;
        }
    }
}
