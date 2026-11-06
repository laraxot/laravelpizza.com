<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Illuminate\Support\Facades\Http;
use Modules\Notify\Actions\SMS\FormatSmsMessageAction;
use Modules\Notify\Actions\SMS\NormalizePhoneNumberAction;
use Modules\Notify\Actions\SMS\SendSmsAction;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);
beforeEach(function (): void {
    $this->sendAction = app(SendSmsAction::class);
    $this->normalizeAction = app(NormalizePhoneNumberAction::class);
    $this->formatAction = app(FormatSmsMessageAction::class);
    Http::fake();
});

afterEach(function (): void {
    Http::assertNothingSent();
});

describe('NormalizePhoneNumberAction', function (): void {
    it('normalizes Italian mobile number', function (): void {
        $result = $this->normalizeAction->execute('+39 300 123 4567');

        Assert::assertSame('+393001234567', $result);
    });

    it('normalizes Italian number without country code', function (): void {
        $result = $this->normalizeAction->execute('300 123 4567');

        Assert::assertSame('+393001234567', $result);
    });

    it('normalizes number with spaces and dashes', function (): void {
        $result = $this->normalizeAction->execute('+39-300-123-4567');

        Assert::assertSame('+393001234567', $result);
    });

    it('handles already normalized number', function (): void {
        $result = $this->normalizeAction->execute('+393001234567');

        Assert::assertSame('+393001234567', $result);
    });

    it('throws exception for invalid number', function (): void {
        expect(fn () => $this->normalizeAction->execute('invalid'))
            ->toThrow(\Exception::class);
    });

    it('handles international numbers', function (): void {
        $result = $this->normalizeAction->execute('+1 555 123 4567');

        Assert::assertSame('+15551234567', $result);
    });
});

describe('FormatSmsMessageAction', function (): void {
    it('formats message within 160 chars (GSM)', function (): void {
        $message = 'Short message';
        [$formattedMessage, $characterCount, $smsCount] = $this->formatAction->execute($message);

        Assert::assertSame($message, $formattedMessage);
        Assert::assertSame(13, $characterCount);
        Assert::assertSame(1, $smsCount);
    });

    it('counts concatenated SMS for messages over 160 chars', function (): void {
        $longMessage = str_repeat('A', 200);
        [$formattedMessage, $characterCount, $smsCount] = $this->formatAction->execute($longMessage);

        Assert::assertSame($longMessage, $formattedMessage);
        Assert::assertGreaterThan(160, $characterCount);
        Assert::assertGreaterThan(1, $smsCount);
    });

    it('handles Unicode characters by normalizing accents', function (): void {
        $message = 'Messaggio con accenti: àèéìòù';
        [$formattedMessage, $characterCount, $smsCount] = $this->formatAction->execute($message);

        Assert::assertStringContainsString("a'", $formattedMessage);
        Assert::assertGreaterThan(0, $characterCount);
        Assert::assertSame(1, $smsCount);
    });

    it('handles emojis (counts as multiple chars)', function (): void {
        $message = 'Test 🎉 emoji';
        [$formattedMessage, $characterCount, $smsCount] = $this->formatAction->execute($message);

        Assert::assertSame($message, $formattedMessage);
        Assert::assertGreaterThan(0, $characterCount);
        Assert::assertGreaterThanOrEqual(1, $smsCount);
    });
});

describe('SendSmsAction', function (): void {
    it('normalizes phone before sending', function (): void {
        $phone = '300 123 4567';
        $normalized = $this->normalizeAction->execute($phone);

        Assert::assertSame('+393001234567', $normalized);
    });
});