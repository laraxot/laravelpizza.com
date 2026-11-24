<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Integrations;

use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Mailtrap SDK bridge is registered as a Laravel mailer', function (): void {
    Assert::assertSame('mailtrap-sdk', config('mail.mailers.mailtrap-sdk.transport'));
    $mailtrap = config('services.mailtrap-sdk');
    Assert::assertIsArray($mailtrap);
    Assert::assertArrayHasKey('apiKey', $mailtrap);
    Assert::assertArrayHasKey('host', $mailtrap);
});

test('mail defaults never use the Laravel example sender', function (): void {
    Assert::assertNotSame('hello@example.com', config('mail.from.address'));
    Assert::assertNotSame('Example', config('mail.from.name'));
    Assert::assertNotSame('noreply@example.com', config('notify.email.default_from_address'));
});
