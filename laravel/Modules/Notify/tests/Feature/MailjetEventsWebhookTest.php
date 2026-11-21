<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Modules\Notify\Events\MailDeliveryEventReceived;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    config(['notify.notify.mailjet_webhook_token' => 'mj-secret']);
    Event::fake([MailDeliveryEventReceived::class]);
});

it('rejects a wrong or missing token', function (): void {
    $this->postJson('/api/notify/mailjet/events/wrong', ['event' => 'sent', 'email' => 'a@example.com'])->assertUnauthorized();

    config(['notify.notify.mailjet_webhook_token' => null]);
    $this->postJson('/api/notify/mailjet/events/mj-secret', ['event' => 'sent', 'email' => 'a@example.com'])->assertUnauthorized();

    Event::assertNotDispatched(MailDeliveryEventReceived::class);
});

it('accepts a single event and a grouped list, and marks permanent failures', function (): void {
    $this->postJson('/api/notify/mailjet/events/mj-secret', [
        'event' => 'bounce', 'time' => 1763460000, 'MessageID' => 19421777835146490, 'email' => 'nessuno@example.com',
        'CustomID' => 'reservation-42', 'Payload' => '', 'hard_bounce' => true, 'error_related_to' => 'recipient', 'error' => 'user unknown',
    ])->assertOk()->assertJson(['handled' => 1]);

    $this->postJson('/api/notify/mailjet/events/mj-secret', [
        ['event' => 'sent', 'time' => 1763460001, 'MessageID' => 1, 'email' => 'cliente@example.com', 'smtp_reply' => '250 OK'],
        ['event' => 'open', 'time' => 1763460100, 'MessageID' => 1, 'email' => 'cliente@example.com'],
        ['event' => 'something-new', 'email' => 'x@example.com'],
        'not-an-object',
    ])->assertOk()->assertJson(['handled' => 2]);

    Event::assertDispatched(MailDeliveryEventReceived::class, fn (MailDeliveryEventReceived $e): bool => $e->event->type === 'bounce'
        && $e->event->permanent
        && $e->event->isFailure()
        && $e->event->customId === 'reservation-42'
        && $e->event->payload === null
        && $e->event->messageId === '19421777835146490'
        && $e->event->reason === 'recipient user unknown'
        && $e->event->at->getTimestamp() === 1763460000);

    Event::assertDispatched(MailDeliveryEventReceived::class, fn (MailDeliveryEventReceived $e): bool => $e->event->type === 'sent'
        && ! $e->event->permanent
        && $e->event->reason === '250 OK');

    Event::assertDispatchedTimes(MailDeliveryEventReceived::class, 3);
});
