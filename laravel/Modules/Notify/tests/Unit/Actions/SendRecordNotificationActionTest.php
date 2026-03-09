<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Actions\SendRecordNotificationAction;
use Modules\Notify\Enums\ChannelEnum;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

uses(TestCase::class);

function makeDummyRecordForNotify(array $attributes = []): Model
{
    return new class($attributes) extends Model
    {
        protected $guarded = [];
    };
}

test('send record notification routes valid mail channel', function () {
    app()->instance(SafeEloquentCastAction::class, new class
    {
        public function getStringAttribute(Model $record, string $attribute, string $default = ''): string
        {
            $value = $record->getAttribute($attribute);

            return is_string($value) ? $value : $default;
        }
    });

    Notification::fake();

    $record = makeDummyRecordForNotify(['email' => 'record@example.test']);

    app(SendRecordNotificationAction::class)->execute(
        record: $record,
        mailTemplateSlug: 'template-slug',
        channels: [ChannelEnum::Mail],
    );

    Notification::assertSentOnDemand(
        RecordNotification::class,
        static function (RecordNotification $notification, array $channels, AnonymousNotifiable $notifiable): bool {
            return ($notifiable->routes['mail'] ?? null) === 'record@example.test';
        }
    );
});

test('send record notification ignores non enum channels', function () {
    Notification::fake();

    $record = makeDummyRecordForNotify();

    app(SendRecordNotificationAction::class)->execute(
        record: $record,
        mailTemplateSlug: 'template-slug',
        channels: ['mail'],
    );

    Notification::assertNothingSent();
});
