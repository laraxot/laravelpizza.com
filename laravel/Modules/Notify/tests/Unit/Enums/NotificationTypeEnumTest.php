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
        $this->assertCount(3, NotificationTypeEnum::cases());

        $this->assertEquals('email', NotificationTypeEnum::EMAIL->value);
        $this->assertEquals('sms', NotificationTypeEnum::SMS->value);
        $this->assertEquals('push', NotificationTypeEnum::PUSH->value);
    }

    /** @test */
    public function label_returns_localized_string(): void
    {
        $this->assertIsString(NotificationTypeEnum::EMAIL->label());
        $this->assertIsString(NotificationTypeEnum::SMS->label());
        $this->assertIsString(NotificationTypeEnum::PUSH->label());
    }

    /** @test */
    public function icon_returns_heroicon_string(): void
    {
        $this->assertEquals('heroicon-o-envelope', NotificationTypeEnum::EMAIL->icon());
        $this->assertEquals('heroicon-o-device-phone-mobile', NotificationTypeEnum::SMS->icon());
        $this->assertEquals('heroicon-o-bell', NotificationTypeEnum::PUSH->icon());
    }

    /** @test */
    public function color_returns_correct_color(): void
    {
        $this->assertEquals('success', NotificationTypeEnum::EMAIL->color());
        $this->assertEquals('warning', NotificationTypeEnum::SMS->color());
        $this->assertEquals('info', NotificationTypeEnum::PUSH->color());
    }

    /** @test */
    public function each_case_has_unique_value(): void
    {
        $values = array_map(fn($case) => $case->value, NotificationTypeEnum::cases());
        $uniqueValues = array_unique($values);

        $this->assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
    }

    /** @test */
    public function cases_returns_all_enum_instances(): void
    {
        $cases = NotificationTypeEnum::cases();

        $this->assertIsArray($cases);
        $this->assertCount(3, $cases);

        foreach ($cases as $case) {
            $this->assertInstanceOf(NotificationTypeEnum::class, $case);
        }
    }

    /** @test */
    public function all_cases_have_required_methods(): void
    {
        foreach (NotificationTypeEnum::cases() as $case) {
            $this->assertIsString($case->label());
            $this->assertIsString($case->icon());
            $this->assertIsString($case->color());
        }
    }
}
