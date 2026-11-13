<?php

declare(strict_types=1);

use Modules\Notify\Models\InboundEmail;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    config(['notify.notify.inbound_token' => 'test-secret-token']);
});

test('inbound webhook rejects requests without valid token', function (): void {
    $this->postJson('/api/inbound/postmark/wrong-token', [
        'MessageID' => 'abc@postmarkapp.com',
        'From' => 'sender@example.com',
        'To' => 'noreply@fixcity.eu',
        'Subject' => 'Test',
    ])->assertUnauthorized();
});

test('inbound webhook rejects requests when token is not configured', function (): void {
    config(['notify.notify.inbound_token' => null]);

    $this->postJson('/api/inbound/postmark/test-secret-token', [
        'MessageID' => 'abc@postmarkapp.com',
        'From' => 'sender@example.com',
    ])->assertUnauthorized();
});

test('inbound webhook stores postmark payload', function (): void {
    $response = $this->postJson('/api/inbound/postmark/test-secret-token', [
        'MessageID' => 'msg-123@postmarkapp.com',
        'From' => 'Mario Rossi <mario@example.com>',
        'To' => 'noreply@fixcity.eu',
        'Subject' => 'Segnalazione guasto',
        'TextBody' => 'Testo della segnalazione',
        'HtmlBody' => '<p>Testo della segnalazione</p>',
        'Headers' => [
            ['Name' => 'Message-ID', 'Value' => '<msg-123@postmarkapp.com>'],
        ],
    ]);

    $response->assertOk()->assertJson(['ok' => true]);

    $email = InboundEmail::query()
        ->where('provider', 'postmark')
        ->where('message_id', 'msg-123@postmarkapp.com')
        ->first();

    expect($email)->not->toBeNull()
        ->and($email->from_email)->toBe('mario@example.com')
        ->and($email->from_name)->toBe('Mario Rossi')
        ->and($email->to_email)->toBe('noreply@fixcity.eu')
        ->and($email->subject)->toBe('Segnalazione guasto')
        ->and($email->text_body)->toBe('Testo della segnalazione')
        ->and($email->status)->toBe('received');
});

test('inbound webhook is idempotent on message id', function (): void {
    $payload = [
        'MessageID' => 'dup-1@postmarkapp.com',
        'From' => 'a@example.com',
        'Subject' => 'Uno',
    ];

    $this->postJson('/api/inbound/postmark/test-secret-token', $payload)->assertOk();
    $this->postJson('/api/inbound/postmark/test-secret-token', array_merge($payload, ['Subject' => 'Due']))->assertOk();

    expect(InboundEmail::query()->where('message_id', 'dup-1@postmarkapp.com')->count())->toBe(1);
});
