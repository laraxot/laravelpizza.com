<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Database\Factories\NotificationFactory;
use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Send notification flow', function (): void {
    test('template lookup returns null when code missing', function (): void {
        $result = NotificationTemplate::query()
            ->where('code', 'missing-template-code')
            ->where('is_active', true)
            ->first();

        Assert::assertNull($result);
    });

    test('template lookup returns model when code exists', function (): void {
        $template = NotificationTemplateFactory::new()->createOne([
            'code' => 'send-test-template',
            'is_active' => true,
        ]);

        $result = NotificationTemplate::query()
            ->where('code', 'send-test-template')
            ->where('is_active', true)
            ->first();

        Assert::assertInstanceOf(NotificationTemplate::class, $result);
        Assert::assertSame($template->id, $result->id);
    });

    test('returns collection from category query', function (): void {
        $result = NotificationTemplate::query()
            ->where('category', 'general')
            ->where('is_active', true)
            ->get();

        Assert::assertInstanceOf(Collection::class, $result);
    });

    test('send action can be invoked with mocked handle', function (): void {
        /** @var TestCase $this */
        NotificationTemplateFactory::new()->createOne([
            'code' => 'action-send-template',
            'is_active' => true,
        ]);

        $recipient = UserFactory::new()->createOne();
        $notification = NotificationFactory::new()->createOne();

        $action = $this->createUnitMock(SendNotificationAction::class);
        $action->expects($this->expectsOnce())
            ->method('handle')
            ->willReturn($notification);

        app()->instance(SendNotificationAction::class, $action);

        $result = app(SendNotificationAction::class)->handle(
            $recipient,
            'action-send-template',
            [],
            [],
            [],
        );

        Assert::assertInstanceOf(Notification::class, $result);
    });

    test('send action throws when template missing', function (): void {
        /** @var TestCase $this */
        $this->expectApplicationException(Exception::class);

        $recipient = UserFactory::new()->createOne();

        app(SendNotificationAction::class)->handle(
            $recipient,
            'invalid_template',
            [],
            [],
            [],
        );
    });
});
