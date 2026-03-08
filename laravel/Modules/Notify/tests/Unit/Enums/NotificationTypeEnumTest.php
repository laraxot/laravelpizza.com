<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\NotificationTypeEnum;
use PHPUnit\Framework\TestCase;

class NotificationTypeEnumTest extends TestCase
{
    /** @test */
    public function it_has_correct_cases(): void
    {
        // @var mixed assertCount(3, NotificationTypeEnum::cases(;

        // @var mixed assertEquals('email', NotificationTypeEnum::EMAIL->value;
        // @var mixed assertEquals('sms', NotificationTypeEnum::SMS->value;
        // @var mixed assertEquals('push', NotificationTypeEnum::PUSH->value;
    }

    /** @test */
    public function label_returns_localized_string(): void
    {
        // @var mixed assertIsString(NotificationTypeEnum::EMAIL->label(;
        // @var mixed assertIsString(NotificationTypeEnum::SMS->label(;
        // @var mixed assertIsString(NotificationTypeEnum::PUSH->label(;
    }

    /** @test */
    public function icon_returns_heroicon_string(): void
    {
        // @var mixed assertEquals('heroicon-o-envelope', NotificationTypeEnum::EMAIL->icon(;
        // @var mixed assertEquals('heroicon-o-device-phone-mobile', NotificationTypeEnum::SMS->icon(;
        // @var mixed assertEquals('heroicon-o-bell', NotificationTypeEnum::PUSH->icon(;
    }

    /** @test */
    public function color_returns_correct_color(): void
    {
        // @var mixed assertEquals('success', NotificationTypeEnum::EMAIL->color(;
        // @var mixed assertEquals('warning', NotificationTypeEnum::SMS->color(;
        // @var mixed assertEquals('info', NotificationTypeEnum::PUSH->color(;
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn ($case) => $case->value, NotificationTypeEnum::cases());
        $uniqueValues = array_unique($values);

        // @var mixed assertCount(count($values;
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = NotificationTypeEnum::cases();

        // @var mixed assertIsArray($cases;
        // @var mixed assertCount(3, $cases;

        foreach ($cases as $case) {
            // @var mixed assertInstanceOf(NotificationTypeEnum::class, $case;
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (NotificationTypeEnum::cases() as $case) {
            // @var mixed assertIsString($case->label(;
            // @var mixed assertIsString($case->icon(;
            // @var mixed assertIsString($case->color(;
        }
    }
}
