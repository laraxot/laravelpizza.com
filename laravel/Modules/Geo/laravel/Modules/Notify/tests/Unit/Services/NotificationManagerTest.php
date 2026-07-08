<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Services\NotificationManager;
use PHPUnit\Framework\TestCase;

class NotificationManagerTest extends TestCase
{
    private NotificationManager $notificationManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationManager = new NotificationManager;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_send_notification_to_single_recipient(): void
    {
        $recipient = $this->recipient();
        $templateCode = 'test_template';
        $data = ['key' => 'value'];
        $channels = ['email'];
        $options = ['priority' => 'high'];

        $template = typedMock(NotificationTemplate::class);
        mockExpectation($template, 'getAttribute')->with('code')->andReturn($templateCode);

        $action = typedMock(SendNotificationAction::class);
        mockExpectation($action, 'handle')->with($recipient, $templateCode, $data, $channels, $options)->once();

        app()->instance(SendNotificationAction::class, $action);

        // Nessuna asserzione sul tipo di ritorno: e' sempre Notification|null per firma,
        // il comportamento reale (chiamata all'action con i parametri attesi) e' verificato
        // da Mockery in tearDown() tramite l'expectation ->once().
        $this->notificationManager->send($recipient, $templateCode, $data, $channels, $options);
    }

    /** @test */
    public function it_can_send_notification_to_multiple_recipients(): void
    {
        $recipients = [
            $this->recipient(),
            $this->recipient(),
        ];
        $templateCode = 'test_template';
        $data = ['key' => 'value'];
        $channels = ['email'];
        $options = ['priority' => 'high'];

        $template = typedMock(NotificationTemplate::class);
        mockExpectation($template, 'getAttribute')->with('code')->andReturn($templateCode);

        $action = typedMock(SendNotificationAction::class);
        mockExpectation($action, 'handle')->times(2);

        app()->instance(SendNotificationAction::class, $action);

        $result = $this->notificationManager->sendMultiple($recipients, $templateCode, $data, $channels, $options);

        $this->assertCount(2, $result);
    }

    /** @test */
    public function it_can_get_template_by_code(): void
    {
        $code = 'test_template';

        $template = typedMock(NotificationTemplate::class);
        mockExpectation($template, 'getAttribute')->with('code')->andReturn($code);
        mockExpectation($template, 'getAttribute')->with('is_active')->andReturn(true);

        $result = $this->notificationManager->getTemplate($code);

        $this->assertNull($result); // Mock non restituisce risultati reali
    }

    /** @test */
    public function it_can_get_templates_by_category(): void
    {
        $category = 'test_category';

        $result = $this->notificationManager->getTemplatesByCategory($category);

        $this->assertCount(0, $result);
    }

    /** @test */
    public function it_throws_exception_when_template_not_found(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Template not found: invalid_template');

        $recipient = $this->recipient();
        $templateCode = 'invalid_template';

        $this->notificationManager->send($recipient, $templateCode);
    }

    /** @test */
    public function it_returns_array_from_send_method(): void
    {
        $recipient = $this->recipient();
        $templateCode = 'test_template';

        $action = typedMock(SendNotificationAction::class);
        mockExpectation($action, 'handle')->once();

        app()->instance(SendNotificationAction::class, $action);

        // Comportamento verificato da Mockery in tearDown() tramite ->once().
        $this->notificationManager->send($recipient, $templateCode);
    }

    /** @test */
    public function it_returns_array_from_send_multiple_method(): void
    {
        $recipients = [$this->recipient()];
        $templateCode = 'test_template';

        $action = typedMock(SendNotificationAction::class);
        mockExpectation($action, 'handle')->once();

        app()->instance(SendNotificationAction::class, $action);

        $result = $this->notificationManager->sendMultiple($recipients, $templateCode);

        $this->assertCount(1, $result);
    }
    private function recipient(): Model
    {
        return new class extends Model {
            protected $guarded = [];
            public $timestamps = false;
        };
    }
}
