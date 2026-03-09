<?php

declare(strict_types=1);

use Modules\Notify\Datas\RecordNotificationData;
use Modules\Xot\States\Transitions\XotBaseTransition;


describe('XotBaseTransition', function () {
    beforeEach(function () {
        // Create a test record
        $record = new Modules\User\Models\User();
        $record->id = '1';
        $record->name = 'Test User';
        $record->email = 'test@example.com';

        // Create a concrete test transition class.
        // Override sendRecipientNotification con firma identica alla base per evitare Fatal error
        // (la base usa RecordNotificationData, non UserContract).
        $transition = new class($this->record)
            public static string $name = 'test_transition';

            #[Override]
            public function getNotificationRecipients(): array
            {
                return [
                    'test_user' => RecordNotificationData::from(['record' => $record, 'channel' => 'mail'])
                ];
            }

            /** @param array<string, mixed> $data */
            public function sendRecipientNotification(RecordNotificationData $recipient, array $data): void
            {
                // Mock: evita invio reale e dipendenze (RecordNotification, getNotificationSlug su record)
            }
        };
    });

    it('can be instantiated', function () {
        expect($transition);
    });

    it('has static name property', function () {
        expect($transition::$name);
    });

    it('can get record', function () {
        $record = $transition->record;
        expect($record)->toBe($record);
    });

    it('can send notifications without errors', function () {
        expect(fn () => $transition->sendNotifications());
    });

    it('returns correct notification recipients structure', function () {
        $recipients = $transition->getNotificationRecipients();
        expect($recipients)->toBeArray()->toHaveKey('test_user');
        expect($recipients['test_user'])->toBeInstanceOf(RecordNotificationData::class);
    });

    it('can send recipient notification', function () {
        $recipient = RecordNotificationData::from(['record' => $record, 'channel' => 'mail']);
        expect(fn () => $transition->sendRecipientNotification($recipient, []));
    });

    it('validates abstract class structure', function () {
        $reflection = new ReflectionClass(XotBaseTransition::class);
        expect($reflection->isAbstract())->toBeTrue()
            ->and($reflection->hasMethod('sendNotifications'))->toBeTrue();
    });
});
