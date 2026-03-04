<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Services;

use Exception;
use Mockery;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Services\NotificationManager;
use Modules\Notify\Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

uses(TestCase::class);

beforeEach(function () {
    $this->notificationManager = new NotificationManager;
    
    NotificationTemplate::truncate();
    
    // Create a real template in the database for the test
    $this->template = NotificationTemplate::create([
        'name' => 'Test Template',
        'code' => 'test_template',
        'subject' => ['en' => 'Test Subject'],
        'body_html' => ['en' => 'Test Body'],
        'channels' => ['email'],
        'variables' => ['user' => 'name'],
        'is_active' => true,
        'category' => 'test_category',
        'type' => \Modules\Notify\Enums\NotificationTypeEnum::EMAIL,
    ]);
});

afterEach(function () {
    Mockery::close();
});

it('can send notification to single recipient', function (): void {
    $recipient = new class extends Model {
        protected $fillable = ['id'];
    };
    $recipient->id = 1;
    
    $templateCode = 'test_template';
    $data = ['key' => 'value'];
    $channels = ['email'];
    $options = ['priority' => 'high'];

    $action = Mockery::mock(SendNotificationAction::class);
    $action->shouldReceive('execute')->with($recipient, $templateCode, $data, $channels, $options)->once();

    app()->instance(SendNotificationAction::class, $action);

    $result = $this->notificationManager->send($recipient, $templateCode, $data, $channels, $options);

    expect($result)->toBeArray();
});

it('can send notification to multiple recipients', function (): void {
    $recipients = [
        new class extends Model { protected $fillable = ['id']; },
        new class extends Model { protected $fillable = ['id']; },
    ];
    $templateCode = 'test_template';
    $data = ['key' => 'value'];
    $channels = ['email'];
    $options = ['priority' => 'high'];

    $action = Mockery::mock(SendNotificationAction::class);
    $action->shouldReceive('execute')->times(2);

    app()->instance(SendNotificationAction::class, $action);

    $result = $this->notificationManager->sendMultiple($recipients, $templateCode, $data, $channels, $options);

    expect($result)->toBeArray()->toHaveCount(2);
});

it('can get template by code', function (): void {
    $code = 'test_template';

    $result = $this->notificationManager->getTemplate($code);

    expect($result)->not->toBeNull()
        ->and($result->code)->toBe($code);
});

it('can get templates by category', function (): void {
    $category = 'test_category';

    $result = $this->notificationManager->getTemplatesByCategory($category);

    expect($result)->toBeObject()->toHaveCount(1);
});

it('throws exception when template not found', function (): void {
    $recipient = new class extends Model {};
    $templateCode = 'invalid_template';

    expect(fn () => $this->notificationManager->send($recipient, $templateCode))
        ->toThrow(Exception::class, 'Template not found: invalid_template');
});

it('has required methods', function (): void {
    expect(method_exists($this->notificationManager, 'send'))->toBeTrue();
    expect(method_exists($this->notificationManager, 'sendMultiple'))->toBeTrue();
    expect(method_exists($this->notificationManager, 'getTemplate'))->toBeTrue();
    expect(method_exists($this->notificationManager, 'getTemplatesByCategory'))->toBeTrue();
});

it('returns array from send method', function (): void {
    $recipient = new class extends Model {};
    $templateCode = 'test_template';

    $action = Mockery::mock(SendNotificationAction::class);
    $action->shouldReceive('execute')->once();

    app()->instance(SendNotificationAction::class, $action);

    $result = $this->notificationManager->send($recipient, $templateCode);

    expect($result)->toBeArray();
});

it('returns array from send multiple method', function (): void {
    $recipients = [new class extends Model {}];
    $templateCode = 'test_template';

    $action = Mockery::mock(SendNotificationAction::class);
    $action->shouldReceive('execute')->once();

    app()->instance(SendNotificationAction::class, $action);

    $result = $this->notificationManager->sendMultiple($recipients, $templateCode);

    expect($result)->toBeArray();
});
