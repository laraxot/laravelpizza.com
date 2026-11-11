<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Notify\Actions\NotificationManager;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Database\Factories\NotificationTemplateFactory;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);
function actionsNotificationManagerActiveTemplate(string $code): NotificationTemplate
{
    return NotificationTemplateFactory::new()->createOne([
        'code' => $code,
        'is_active' => true,
    ]);
}

function actionsNotificationManagerRecipient(): Model
{
    return new class extends Model
    {
        protected $guarded = [];

        public $timestamps = false;
    };
}

afterEach(function (): void {
    Mockery::close();
});

it('can send notification to single recipient', function (): void {
    $notificationManager = new NotificationManager;
    $recipient = actionsNotificationManagerRecipient();
    $templateCode = 'test_template';
    $data = ['key' => 'value'];
    $channels = ['email'];
    $options = ['priority' => 'high'];

    actionsNotificationManagerActiveTemplate($templateCode);
    $sent = new Notification;

    $action = TestCase::typedMock(SendNotificationAction::class);
    TestCase::mockExpectation($action, 'handle')
        ->with($recipient, $templateCode, $data, $channels, $options)
        ->once()
        ->andReturn($sent);

    app()->instance(SendNotificationAction::class, $action);

    expect($notificationManager->send($recipient, $templateCode, $data, $channels, $options))->toBe($sent);
});

it('can send notification to multiple recipients', function (): void {
    $notificationManager = new NotificationManager;
    $recipients = [
        actionsNotificationManagerRecipient(),
        actionsNotificationManagerRecipient()];
    $templateCode = 'test_template';
    $data = ['key' => 'value'];
    $channels = ['email'];
    $options = ['priority' => 'high'];

    actionsNotificationManagerActiveTemplate($templateCode);

    $action = TestCase::typedMock(SendNotificationAction::class);
    TestCase::mockExpectation($action, 'handle')->times(2)->andReturn(new Notification);

    app()->instance(SendNotificationAction::class, $action);

    $result = $notificationManager->sendMultiple($recipients, $templateCode, $data, $channels, $options);

    expect($result)->toHaveCount(2);
});

it('can get template by code', function (): void {
    $notificationManager = new NotificationManager;
    $code = 'test_template';

    expect($notificationManager->getTemplate($code))->toBeNull();

    $template = actionsNotificationManagerActiveTemplate($code);

    $result = $notificationManager->getTemplate($code);

    expect($result)->toBeInstanceOf(NotificationTemplate::class);
    expect($result?->id)->toBe($template->id);
});

it('can get templates by category', function (): void {
    $notificationManager = new NotificationManager;
    $category = 'test_category';

    $result = $notificationManager->getTemplatesByCategory($category);

    expect($result)->toHaveCount(0);
});

it('throws exception when template not found', function (): void {
    $notificationManager = new NotificationManager;
    $recipient = actionsNotificationManagerRecipient();
    $templateCode = 'invalid_template';

    expect(fn () => $notificationManager->send($recipient, $templateCode))
        ->toThrow(Exception::class, 'Template not found: invalid_template');
});

it('returns array from send method', function (): void {
    $notificationManager = new NotificationManager;
    $recipient = actionsNotificationManagerRecipient();
    $templateCode = 'test_template';
    actionsNotificationManagerActiveTemplate($templateCode);

    $action = TestCase::typedMock(SendNotificationAction::class);
    TestCase::mockExpectation($action, 'handle')->once()->andReturn(null);

    app()->instance(SendNotificationAction::class, $action);

    expect($notificationManager->send($recipient, $templateCode))->toBeNull();
});

it('returns array from send multiple method', function (): void {
    $notificationManager = new NotificationManager;
    $recipients = [actionsNotificationManagerRecipient()];
    $templateCode = 'test_template';
    actionsNotificationManagerActiveTemplate($templateCode);

    $action = TestCase::typedMock(SendNotificationAction::class);
    TestCase::mockExpectation($action, 'handle')->once()->andReturn(new Notification);

    app()->instance(SendNotificationAction::class, $action);

    $result = $notificationManager->sendMultiple($recipients, $templateCode);

    expect($result)->toHaveCount(1);
});
