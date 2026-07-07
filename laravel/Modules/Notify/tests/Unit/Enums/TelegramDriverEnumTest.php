<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\TelegramDriverEnum;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

it('has correct cases', function (): void {
    Assert::assertCount(3, TelegramDriverEnum::cases());

    Assert::assertSame('telegram', TelegramDriverEnum::TELEGRAM->value);
    Assert::assertSame('botapi', TelegramDriverEnum::BOTAPI->value);
    Assert::assertSame('laravel-telegram', TelegramDriverEnum::LARAVEL_TELEGRAM->value);
});

it('options returns correct array', function (): void {
    $options = TelegramDriverEnum::options();
    Assert::assertCount(3, $options);
    Assert::assertSame('Telegram', $options['telegram']);
    Assert::assertSame('Bot API', $options['botapi']);
    Assert::assertSame('Laravel Telegram', $options['laravel-telegram']);
});

it('labels returns localized array', function (): void {
    $labels = TelegramDriverEnum::labels();
    Assert::assertCount(3, $labels);
    Assert::assertArrayHasKey('telegram', $labels);
    Assert::assertArrayHasKey('botapi', $labels);
    Assert::assertArrayHasKey('laravel-telegram', $labels);
});

it('is supported returns true for valid drivers', function (): void {
    Assert::assertTrue(TelegramDriverEnum::isSupported('telegram'));
    Assert::assertTrue(TelegramDriverEnum::isSupported('botapi'));
    Assert::assertTrue(TelegramDriverEnum::isSupported('laravel-telegram'));
});

it('is supported returns false for invalid drivers', function (): void {
    Assert::assertFalse(TelegramDriverEnum::isSupported('invalid'));
    Assert::assertFalse(TelegramDriverEnum::isSupported(''));
    Assert::assertFalse(TelegramDriverEnum::isSupported('TELEGRAM'));
    Assert::assertFalse(TelegramDriverEnum::isSupported('Telegram'));
});

it('get default returns default driver', function (): void {
    config(['telegram.default' => TelegramDriverEnum::TELEGRAM->value]);

    $default = TelegramDriverEnum::getDefault();

    Assert::assertInstanceOf(TelegramDriverEnum::class, $default);
    Assert::assertContains($default, TelegramDriverEnum::cases());
});

it('each case has unique value', function (): void {
    $values = array_map(static fn ($case) => $case->value, TelegramDriverEnum::cases());
    $uniqueValues = array_unique($values);

    Assert::assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
});

it('cases returns all enum instances', function (): void {
    $cases = TelegramDriverEnum::cases();
    Assert::assertCount(3, $cases);

    foreach ($cases as $case) {
        Assert::assertInstanceOf(TelegramDriverEnum::class, $case);
    }
});

it('all cases expose non empty description', function (): void {
    foreach (TelegramDriverEnum::cases() as $case) {
        Assert::assertNotEmpty($case->getDescription());
    }
});
