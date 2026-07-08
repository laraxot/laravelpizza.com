<?php

declare(strict_types=1);

use Modules\Notify\Datas\RecordNotificationData;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\States\Transitions\XotBaseTransition;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('XotBaseTransition', function (): void {
    it('can be instantiated', function (): void {
        [, $transition] = xotBaseTransitionFixture();

        Assert::assertInstanceOf(XotBaseTransition::class, $transition);
    });

    it('has static name property', function (): void {
        [, $transition] = xotBaseTransitionFixture();

        Assert::assertTrue(property_exists($transition, 'name'));
    });

    it('has record property', function (): void {
        [, $transition] = xotBaseTransitionFixture();

        Assert::assertTrue(property_exists($transition, 'record'));
    });

    it('can get record', function (): void {
        [$record, $transition] = xotBaseTransitionFixture();

        Assert::assertSame($record, $transition->record);
    });

    it('has sendNotifications method', function (): void {
        [, $transition] = xotBaseTransitionFixture();

        Assert::assertTrue(method_exists($transition, 'sendNotifications'));
    });

    it('can send notifications without errors', function (): void {
        $record = UserFactory::new()->createOne();

        $transition = new class($record) extends XotBaseTransition {
            public static string $name = 'test_transition';

            public function sendRecipientNotification(RecordNotificationData $recipient, array $data): void
            {
            }
        };

        $transition->sendNotifications();
    });

    it('has getNotificationRecipients method', function (): void {
        [, $transition] = xotBaseTransitionFixture();

        Assert::assertTrue(method_exists($transition, 'getNotificationRecipients'));
    });

    it('returns correct notification recipients structure', function (): void {
        $record = UserFactory::new()->createOne();

        $transition = new class($record) extends XotBaseTransition {
            public static string $name = 'test_transition';
        };

        $recipients = $transition->getNotificationRecipients();

        Assert::assertArrayHasKey('me_mail', $recipients);
        Assert::assertInstanceOf(RecordNotificationData::class, $recipients['me_mail']);
    });

    it('has sendRecipientNotification method', function (): void {
        [, $transition] = xotBaseTransitionFixture();

        Assert::assertTrue(method_exists($transition, 'sendRecipientNotification'));
    });

    it('processes recipients correctly in sendNotifications', function (): void {
        $record = UserFactory::new()->createOne();

        $transition = new class($record) extends XotBaseTransition {
            public static string $name = 'test_mixed_transition';

            /**
             * @return array<string, RecordNotificationData>
             */
            public function getNotificationRecipients(): array
            {
                return [
                    'valid_recipient' => RecordNotificationData::from(['record' => $this->record, 'channel' => 'mail']),
                ];
            }

            public function sendRecipientNotification(RecordNotificationData $recipient, array $data): void
            {
            }
        };

        $transition->sendNotifications();
    });
});
