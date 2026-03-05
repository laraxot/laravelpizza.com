<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Actions\SMS\NormalizePhoneNumberAction;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Channels\WhatsAppChannel;
use Modules\Notify\Enums\ChannelEnum;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

uses(TestCase::class);

test('notification channel mapping is correct', function () {
    expect(ChannelEnum::Mail->getNotificationChannel())->toBe('mail')
        ->and(ChannelEnum::Sms->getNotificationChannel())->toBe(SmsChannel::class)
        ->and(ChannelEnum::WhatsApp->getNotificationChannel())->toBe(WhatsAppChannel::class);
});

test('mail recipient is resolved only for valid email', function () {
    app()->instance(SafeEloquentCastAction::class, new class
    {
        public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
        {
            $value = $record->getAttribute($attribute);

            return is_string($value) ? $value : $default;
        }
    });

    $valid = new class extends Model
    {
        protected $guarded = [];
    };
    $valid->setAttribute('email', 'notify@example.test');

    $invalid = new class extends Model
    {
        protected $guarded = [];
    };
    $invalid->setAttribute('email', 'not-an-email');

    expect(ChannelEnum::Mail->getRecipient($valid))->toBe('notify@example.test')
        ->and(ChannelEnum::Mail->getRecipient($invalid))->toBeNull();
});

test('sms and whatsapp recipients are normalized', function () {
    app()->instance(SafeEloquentCastAction::class, new class
    {
        public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
        {
            $value = $record->getAttribute($attribute);

            return is_string($value) ? $value : $default;
        }
    });

    app()->instance(NormalizePhoneNumberAction::class, new class
    {
        public function execute(string $phone): string
        {
            return '+39'.preg_replace('/\D+/', '', $phone);
        }
    });

    $record = new class extends Model
    {
        protected $guarded = [];
    };
    $record->setAttribute('phone', ' 333-12-34-567 ');
    $record->setAttribute('whatsapp', ' 388 99 77 66 ');

    expect(ChannelEnum::Sms->getRecipient($record))->toBe('+393331234567')
        ->and(ChannelEnum::WhatsApp->getRecipient($record))->toBe('+39388997766');
});
