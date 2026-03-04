<?php

declare(strict_types=1);

use Modules\Xot\States\Transitions\XotBaseTransition;
use Modules\Notify\Datas\RecordNotificationData;
use Tests\TestCase;

uses(TestCase::class);

describe('XotBaseTransition', function () {
    beforeEach(function () {
        // Create a test record
        $this->record = new \Modules\User\Models\User();
        $this->record->id = '1';
        $this->record->name = 'Test User';
        $this->record->email = 'test@example.com';

        // Create a concrete test transition class.
        $this->transition = new class($this->record) extends XotBaseTransition {
            public static string $name = 'test_transition';

            public function getNotificationRecipients(): array
            {
                return [
                    'test_user' => RecordNotificationData::from(['record' => $this->record, 'channel' => 'mail']),
                ];
            }

            public function sendRecipientNotification(RecordNotificationData $recipient, array $data): void
            {
                // Mock: evita invio reale e dipendenze
            }
        };
    });

    it('can be instantiated', function () {
        expect($this->transition)->toBeInstanceOf(XotBaseTransition::class);
    });

    it('has static name property', function () {
        expect($this->transition::$name)->toBe('test_transition');
    });

    it('can get record', function () {
        $record = $this->transition->record;
        expect($record)->toBe($this->record);
    });

    it('can send notifications without errors', function () {
        expect(fn() => $this->transition->sendNotifications())->not->toThrow(Exception::class);
    });

    it('returns correct notification recipients structure', function () {
        $recipients = $this->transition->getNotificationRecipients();
        expect($recipients)->toBeArray()->toHaveKey('test_user');
        expect($recipients['test_user'])->toBeInstanceOf(RecordNotificationData::class);
    });

    it('can send recipient notification', function () {
        $recipient = RecordNotificationData::from(['record' => $this->record, 'channel' => 'mail']);
        expect(fn() => $this->transition->sendRecipientNotification($recipient, []))->not->toThrow(Exception::class);
    });

    it('validates abstract class structure', function () {
        $reflection = new ReflectionClass(XotBaseTransition::class);
        expect($reflection->isAbstract())->toBeTrue()
            ->and($reflection->hasMethod('sendNotifications'))->toBeTrue();
    });
});
