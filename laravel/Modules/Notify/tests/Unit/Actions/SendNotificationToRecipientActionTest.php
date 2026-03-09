<?php

declare(strict_types=1);

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification as IlluminateNotification;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Actions\SendNotificationToRecipientAction;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

function makeDummyNotificationForRecipient(): IlluminateNotification
{
    return new class extends IlluminateNotification
    {
        public function via(object $notifiable): array
        {
            return ['mail'];
        }
    };
}

test('send notification to recipient returns true and routes mail', function () {
    Notification::fake();
    $notification = makeDummyNotificationForRecipient();

    $result = app(SendNotificationToRecipientAction::class)->execute(
        'user@example.test',
        $notification,
    );

    expect($result)->toBeTrue();

    Notification::assertSentOnDemand(
        $notification::class,
        static function (IlluminateNotification $notification, array $channels, AnonymousNotifiable $notifiable): bool {
            return ($notifiable->routes['mail'] ?? null) === 'user@example.test';
        }
    );
});

test('send notification to recipient throws for invalid email', function () {
    app(SendNotificationToRecipientAction::class)->execute(
        'invalid-email',
        makeDummyNotificationForRecipient(),
    );
})->throws(InvalidArgumentException::class);
