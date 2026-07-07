<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Support\Facades\File;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

uses(\Modules\Notify\Tests\TestCase::class);

test('components json is valid and contains expected components', function (): void {
    $filePath = base_path('Modules/Notify/app/Console/Commands/_components.json');

    Assert::assertTrue(File::exists($filePath));

    $json = \assertNotifyArray(json_decode(File::get($filePath), true));

    Assert::assertCount(2, $json);

    $first = \assertNotifyArray($json[0] ?? null);
    $second = \assertNotifyArray($json[1] ?? null);

    Assert::assertArrayHasKey('name', $first);
    Assert::assertArrayHasKey('class', $first);
    Assert::assertArrayHasKey('ns', $first);
    Assert::assertArrayHasKey('name', $second);
    Assert::assertArrayHasKey('class', $second);
    Assert::assertArrayHasKey('ns', $second);

    $names = array_column($json, 'name');
    Assert::assertContains('send-mail-command', $names);
    Assert::assertContains('telegram-webhook', $names);

    $classes = array_column($json, 'class');
    Assert::assertContains('SendMailCommand', $classes);
    Assert::assertContains('TelegramWebhook', $classes);
});
